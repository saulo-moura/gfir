<html dir="ltr">
    <head>
        <title></title>
        <style type="text/css">
            body
            {
                background-color: #ffffff;
                padding: 5px 5px 5px 5px;
                margin: 0px;
            }

            body, td
            {
                font-family: Arial, Verdana, sans-serif;
                font-size: 12px;
            }

            a[href]
            {
                color: -moz-hyperlinktext !important;		/* For Firefox... mark as important, otherwise it becomes black */
                text-decoration: -moz-anchor-decoration;	/* For Firefox 3, otherwise no underline will be used */
            }

            .Bold
            {
                font-weight: bold;
            }

            .Title
            {
                font-weight: bold;
                font-size: 18px;
                color: #cc3300;
            }

            .Code
            {
                border: #8b4513 1px solid;
                padding-right: 5px;
                padding-left: 5px;
                color: #000066;
                font-family: 'Courier New' , Monospace;
                background-color: #ff9933;
            }

        </style>
    </head>
    <body>
        <script type="text/javascript">
            var txt = '#' + location.search.substring(4, location.search.length);
            document.write(parent.$(txt).val());
        </script>
    </body>
</html>