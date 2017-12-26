/*jquery.cascade.js */
/*
 * jQuery UI cascade
 *
 * Adapted from Yehuda Katz, Rein Henrichs autocomplete plugin.
 *
 * @version: 1.3.2 (2011-01-17)
 * @requires: jQuery v1.3 or later
 * @license: http://www.opensource.org/licenses/mit-license.php
 * @license: http://www.gnu.org/licenses/gpl.html
 * @copyright 2008 Mike Nichols
 * @author Mike Nichols
 * @author Eugene Janusov <esycat@gmail.com>
 */

;
(function ($) {
    $.ui = $.ui || {};
    $.ui.cascade = $.ui.cascade || {};

    $.ui.cascade.namespace = 'cascade';

    $.fn.cascade = function (parent, opt) {
        var namespace = $.ui.cascade.namespace;

        if (opt.event) {
            // namespace our event
            opt.event = opt.event.replace('.' + namespace, '') + '.' + namespace;
        }

        opt = $.extend({}, {
            datalist: [], // data list to use as datasource
            list: [], // static list to use as datasource
            timeout: 0, // delay before firing getList operation
            getList: function (select) {
                $(this).trigger('updateList', [opt.list]);
            }, // function to fetch datasource
            template: function (item) {
                var attrdata = '';
                
                for (var x in opt.datalist) {
                    attrdata += ' data-' + opt.datalist[x] + '="'+ url_decode(item[opt.datalist[x]]) +'"';
                }

                return '<option data-optgroup="' + url_decode(item.optgroup) + '"' + attrdata + ' value="' + item.value + '">' + url_decode(item.text) + '</option>';
            }, // applied to each item in datasource
            match: function (selectedValue) {
                return this.when == selectedValue;
            }, // 'this' is the js object, or the current list item from 'getList'
            event: 'change.' + namespace, // event to listen on parent which fires the cascade
            getParentValue: function (parent) {
                return $(parent).val();
            } // delegate for retrieving the parent element's value
        }, opt);

        if ($.ui.cascade.ext) {
            for (var ext in $.ui.cascade.ext) {
                if (opt[ext]) {
                    opt = $.extend(opt, $.ui.cascade.ext[ext](opt));
                    delete opt[ext];
                }
            }
        }

        return this.each(function () {
            var source = $(parent);
            var self = $(this);
            var curVal = self.val();

            // bind any events in extensions to each instance
            if ($.ui.cascade.event) {
                for (var e in $.ui.cascade.event) {
                    self.bind(e + '.' + namespace, {
                        source: source[0]
                    }, $.ui.cascade.event[e]);
                }
            }

            $(source).bind(opt.event, function (event, chain) {
                // Do not propgagate if current element is one of the previous parents.
                // This prevents infinite loop for interdependent dropdowns.
                chain = chain || [];

                if ($.inArray(self[0], chain) != -1) {
                    return false;
                }

                chain.push(this); // add current element on stack

                // store current value first of all, even loading event can modify the select element
                curVal = self.val();

                self.trigger('loading.' + namespace, [source[0]]);

                var selectTimeout = $.data(self, 'selectTimeout');
                if (selectTimeout) {
                    window.clearInterval(selectTimeout);
                }

                $.data(self, 'selectTimeout', window.setTimeout(function () {
                    self.trigger(namespace, [chain]);
                }, opt.timeout));
            });

            self.bind(namespace, function (event, chain) {
                // In case if a dropdown participates in multiple cascades,
                // this event can be falsely fired multiple times.
                // Check for proper parent on the stack to prevent triggering.
                if (chain && $.inArray(source[0], chain) == -1)
                    return false;

                self.one('updateList', function (event, list) {
                    list = $(list)
                            .filter(function () {
                                return opt.match.call(this, opt.getParentValue(parent));
                            })
                            .map(function () {
                                var $node = $(opt.template(this));
                                return $node[0];
                            });

                    var listFinal = $('<select />');

                    list.each(function () {
                        var lbl = $(this).data('optgroup');

                        if (lbl == '') {
                            listFinal.append($(this));
                        } else {
                            if (listFinal.find('optgroup[label="' + lbl + '"]').length == 0) {
                                var obj_opt = $('<optgroup/>').attr('label', lbl);
                                listFinal.append(obj_opt);
                            }

                            listFinal.find('optgroup[label="' + lbl + '"]').append($(this));
                        }
                    });

                    self.empty(); // clear the source/select

                    list = listFinal.children();

                    if (list.length) {
                        self.html(list);
                    }

                    if (curVal == '' || curVal == null) {
                        if (self.data('cascade_val') != undefined) {
                            curVal = self.data('cascade_val');
                            self.removeAttr('data-cascade_val');
                        }

                        if (self.data('cascade_txt') != undefined) {
                            curVal = self.data('cascade_txt');

                            var select_option = self.find('option').filter(function () {
                                return $.trim($(this).text()) == curVal;
                            });

                            curVal = select_option.val();
                            self.removeAttr('data-cascade_val');
                        }
                    }

                    if (curVal != null) {
                        self.val(curVal); // restore original value if possible and if parent's value is not null
                    }

                    self.trigger('loaded.' + namespace, [source[0]]); // be sure to fire even if there is no data

                    // opinionated, but enables cascading from this element as well
                    if (self.is(':input')) {
                        self.trigger('change.' + namespace, [chain]);
                    }
                });

                opt.getList.call(self[0], source); // call with child element as this
            });
        });

    };

})(jQuery);
