<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<title></title>
	<style>
    #_prom{
	width:500px;
	background:#057e9c;
		}

	#encabezado{
	position: relative;
	margin-left:auto;
	margin-right:auto;
	height: 59px;
	width: 401px;
		}
	#mensaje{
	position:relative;
	background-color:#FFF;
	margin-left:auto;
	margin-right:auto;
	height: 300px;
	width: 385px;
	font-family: Corbel;
	text-align:justify;
	font-size: 14px;
	color:#000;
	}


#pie_p{
	position: relative;
	margin-left:auto;
	margin-right:auto;
	height: 97px;
	/*width: 401px;*/
	font-family:Corbel;
	font-size:10px;
	color:#FFF;
	text-align:justify;
	}
#pie_pag{
		text-align:justify;
		color:#FFF;
		font:Corbel;
		font-size:10px;
	}
#link{
		text-align:center;
		color:#FFF;
		font-family:Corbel;
		font-size:14px;
		font:bold;
		text-decoration:underline;
}
#sig{
	text-align:center;
		color:#FFF;
		font:Corbel;
		font-size:14px;
		font:bold;
	}
    </style>
</head>



<body>
<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" style="margin:auto;">
<tr>
<td width="30%">&nbsp;</td>
<td width="5%"  bgcolor="#057e9c">&nbsp;</td>
<td  width="30%" bgcolor="#057e9c">&nbsp;</td>
<td width="5%"  bgcolor="#057e9c">&nbsp;</td>
<td width="30%">&nbsp;</td>
</tr>
<tr>
<td width="30%">&nbsp;

</td>
<td width="5%"  bgcolor="#057e9c">&nbsp;

</td>
<td align="center" width="30%">
<div id="_prom" align="center">
    		<div id="encabezado">
            <img src="cid:image1" width="401" height="59" />
            </div>
  <table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" border="0">
  <tr>
  <td bgcolor="#057e9c">&nbsp;

  </td>
  <td bgcolor="#FFF">&nbsp;

  </td>
  <td width="390px">
  <div id="mensaje">
			<?php echo $this->fetch('content');?>
  </div>

  </td>
  <td bgcolor="#FFF">&nbsp;

  </td>
  <td bgcolor="#057e9c">&nbsp;

  </td>
  </tr>
  </table>
        <div>
            <table id="pie_p" bgcolor="#057e9c">
            	<tr>
            		<td width="45%">
              			<label id="pie_pag">Este correo es enviado autom&aacute;ticamente para fines informativos, por favor no responda a esta direcci&oacute;n. Si deseas contactarnos puedes hacerlo a trav&eacute;s de contacto.ne@nuestroempleo.com.mx</label>
                    </td>
            		<td width="30%">
            		<table width="100%">
            			<tr>
            			<td colspan="3" align="center" id="sig">
            			<label style="text-align:center;color:#FFF;font:Corbel;font-size:14px;font:bold;">S&iacute;guenos!!</label>
            			</td>
            			</tr>
            			<tr>
            			<td>
            				<a href="#"><img src="cid:FB" style="margin-left:auto;margin-right:auto" /></a>
            			</td>
            			<td>
            				<a href="#"><img src="cid:TW" style="margin-left:auto;margin-right:auto" /></a>
            			</td>
            			<td>
            				<a href="#"><img src="cid:IN" style="margin-left:auto;margin-right:auto" /></a>
            			</td>
            			</tr>
            		</table>
            	</td>
            	<td width="25%" align="center">&nbsp;
            		<a href="<?= $this->webroot  ?>"  > <img src="cid:image2" style="margin-left:auto;margin-right:auto" /> </a>
            	</td>
            </tr>
            </table>
           </p>
           <label><a href="<?=$this->webroot ?>" id="link">www.nuestroempleo.com.mx</a></label>
          </div>
          <br />
</div>
</td>
<td width="5%"  bgcolor="#057e9c">&nbsp;

</td>
<td width="30%">&nbsp;
</td>
</tr>
</table>
</body>
</html>