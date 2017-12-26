<style type="text/css">
    #titulo_cubo_meta7 {
        background:#0000FF;
		color:#FFFFFF;
		font-size:16px;
		text-align:center;
		margin: 30px;
    }

    #cubo_meta7 {
        font-size: 12px;
		margin:30px;
    }
</style>
<script type="text/javascript">
    $(function () {
        var url_cubo = '<?php echo url; ?>/obj_file/cubo/';

        Papa.parse(url_cubo + 'crm_cubo_meta7.cub', {
            download: true,
			skipEmptyLines: true,
            complete: function (parsed) {
                $("#cubo_meta7").pivotUI(
                        parsed.data, {
                            //rows: ["Province"],
                            //cols: ["Party"]
                        },
                        false,
                        "pt"
                        );
            }
        });
    });
</script>

<div id="titulo_cubo_meta7" style="">
CRM - CUBO META 7
</div>

<div id="cubo_meta7" style=""></div>