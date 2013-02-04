<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Generate Migration</title>
		<style>
			body{width: 960px; margin: 0 auto;}
			.important{color: #b94a48; background-color:#fcf8e3;}
			button{cursor: pointer;}
			fieldset{position: relative;}
			#file-detail{border: black solid 1px; padding: 20px;}
			#file-preview{border: black solid 2px; padding: 10px;}
			a.btn{
				text-decoration: none;
			}
			.btn {
			  font-size: 26px;
			  padding: 0.5em 1.5em;
			  display: inline-block;
			  width: auto;
			  height: auto;
			  cursor: pointer;
			  -moz-border-radius: 8px;
			  -webkit-border-radius: 8px;
			  -o-border-radius: 8px;
			  -ms-border-radius: 8px;
			  -khtml-border-radius: 8px;
			  border-radius: 8px;
			  background-color: #1B84B6;
			  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #3CACE2), color-stop(70%, #1B84B6));
			  background: -webkit-linear-gradient(#3CACE2, #1B84B6 70%);
			  background: -moz-linear-gradient(#3CACE2, #1B84B6 70%);
			  background: -o-linear-gradient(#3CACE2, #1B84B6 70%);
			  background: -ms-linear-gradient(#3CACE2, #1B84B6 70%);
			  background: linear-gradient(#3CACE2, #1B84B6 70%);
			  -moz-box-shadow: #7ec8ec 0 1px 0 inset;
			  -webkit-box-shadow: #7ec8ec 0 1px 0 inset;
			  -o-box-shadow: #7ec8ec 0 1px 0 inset;
			  box-shadow: #7ec8ec 0 1px 0 inset;
			  border: 1px solid #1874a0;
			  color: white;
			  text-shadow: #135f83 0 -1px 0;
			}
			.btn.small{
				font-weight: normal;
				font-size: 12px;
			}
			.btn:hover {
			  background-color: #1874a0;
			  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(3%, #25a3df), color-stop(75%, #1874a0));
			  background: -webkit-linear-gradient(#25a3df 3%, #1874a0 75%);
			  background: -moz-linear-gradient(#25a3df 3%, #1874a0 75%);
			  background: -o-linear-gradient(#25a3df 3%, #1874a0 75%);
			  background: -ms-linear-gradient(#25a3df 3%, #1874a0 75%);
			  background: linear-gradient(#25a3df 3%, #1874a0 75%);
			}
			.btn:active {
			  -moz-box-shadow: #166a92 0 1px 2px inset;
			  -webkit-box-shadow: #166a92 0 1px 2px inset;
			  -o-box-shadow: #166a92 0 1px 2px inset;
			  box-shadow: #166a92 0 1px 2px inset;
			}
			.btn.danger{
			  background-color: #cc3512;
			  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #ee5e3d), color-stop(70%, #cc3512));
			  background: -webkit-linear-gradient(#ee5e3d, #cc3512 70%);
			  background: -moz-linear-gradient(#ee5e3d, #cc3512 70%);
			  background: -o-linear-gradient(#ee5e3d, #cc3512 70%);
			  background: -ms-linear-gradient(#ee5e3d, #cc3512 70%);
			  background: linear-gradient(#ee5e3d, #cc3512 70%);
			  -moz-box-shadow: #f49883 0 1px 0 inset;
			  -webkit-box-shadow: #f49883 0 1px 0 inset;
			  -o-box-shadow: #f49883 0 1px 0 inset;
			  box-shadow: #f49883 0 1px 0 inset;
			  border: 1px solid #b52f10;
			  text-shadow: #96270d 0 -1px 0;
			}
			.btn.danger:hover{
			  background-color: #b52f10;
			  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(3%, #ec4b25), color-stop(75%, #b52f10));
			  background: -webkit-linear-gradient(#ec4b25 3%, #b52f10 75%);
			  background: -moz-linear-gradient(#ec4b25 3%, #b52f10 75%);
			  background: -o-linear-gradient(#ec4b25 3%, #b52f10 75%);
			  background: -ms-linear-gradient(#ec4b25 3%, #b52f10 75%);
			  background: linear-gradient(#ec4b25 3%, #b52f10 75%);
			}
			.btn.danger:active {
			  -moz-box-shadow: #a72b0f 0 1px 2px inset;
			  -webkit-box-shadow: #a72b0f 0 1px 2px inset;
			  -o-box-shadow: #a72b0f 0 1px 2px inset;
			  box-shadow: #a72b0f 0 1px 2px inset;
			}
			.btn.success{
			  background-color: #acbd4f;
			  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(0%, #bac86d), color-stop(70%, #acbd4f));
			  background: -webkit-linear-gradient(#bac86d, #acbd4f 70%);
			  background: -moz-linear-gradient(#bac86d, #acbd4f 70%);
			  background: -o-linear-gradient(#bac86d, #acbd4f 70%);
			  background: -ms-linear-gradient(#bac86d, #acbd4f 70%);
			  background: linear-gradient(#bac86d, #acbd4f 70%);
			  -moz-box-shadow: #d4dda4 0 1px 0 inset;
			  -webkit-box-shadow: #d4dda4 0 1px 0 inset;
			  -o-box-shadow: #d4dda4 0 1px 0 inset;
			  box-shadow: #d4dda4 0 1px 0 inset;
			  border: 1px solid #9fb042;
			  text-shadow: #748130 0 -1px 0;
			}
			.btn.success:hover{
			  background-color: #99a93f;
			  background: -webkit-gradient(linear, 50% 0%, 50% 100%, color-stop(3%, #aebe53), color-stop(75%, #99a93f));
			  background: -webkit-linear-gradient(#aebe53 3%, #99a93f 75%);
			  background: -moz-linear-gradient(#aebe53 3%, #99a93f 75%);
			  background: -o-linear-gradient(#aebe53 3%, #99a93f 75%);
			  background: -ms-linear-gradient(#aebe53 3%, #99a93f 75%);
			  background: linear-gradient(#aebe53 3%, #99a93f 75%);
			}
			.btn.success:active {
			  -moz-box-shadow: #95a53e 0 1px 2px inset;
			  -webkit-box-shadow: #95a53e 0 1px 2px inset;
			  -o-box-shadow: #95a53e 0 1px 2px inset;
			  box-shadow: #95a53e 0 1px 2px inset;
			}

		</style>
	</head>
	<body>
		<h1>Will generate <?php echo $filename; ?></h1>
		<div id="file-detail">
			<pre>
				<?php highlight_string($file); ?>
			</pre>
		</div>
		<br><br>
		<a class="btn" href="<?php echo base_url("generate/create_migration"); ?>">Generate</a>
		<br><br><br>
	</body>
</html>