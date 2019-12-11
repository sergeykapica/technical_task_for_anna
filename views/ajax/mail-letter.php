<div id="main-wrapper" style="position: relative; float: left; width: 100%; background: url(http://i.piccy.info/i9/1c4488f886a8a0238b8957c83a220e10/1575576884/104962/1351218/photoeditorsdk_export.jpg) no-repeat center; background-size: cover ;background-attachment: fixed; font-size: 16px; font-family: OpenSansCondensed; word-wrap: break-word;">
	<header id="main-header" style="width: 100%; min-height: 50px; float: left; background-color: rgba(0, 0, 0, 0.5); border-bottom: 2px dashed #fff; color: #fff;">
		<div class="main-header-left" style="width: 50%; float: left; min-height: inherit; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; padding-left: 1rem;">
			<h3 class="main-logotype" style="margin-top: calc(60px - 1rem); margin-bottom: 0; font-size: 2rem;"><?=$variables['HOST'];?></h3>
		</div>
	<div class="main-header-right" style="width: 50%; float: left; min-height: inherit; box-sizing: border-box; -moz-box-sizing: border-box; -webkit-box-sizing: border-box;"></div>
	</header>
	<div id="main-content" style="width: calc(100% - 4rem); float: left; padding: 2rem;">
		<div id="content-wrapper" style="background-color: rgba(255, 255, 255, 0.7); padding: 1rem;">
			<p style="margin: 0 0 .5rem 0; color: rgba(0, 0, 0, 0.7);"><?=$variables['EMAIL_APPEAL_USER'] . ' ' . $variables['USER_NAME'] . '. ' . $variables['EMAIL_TEXT'];?> <span style="color: #EB8270;"><?=$variables['INVITATION_CODE'];?></span></p>
            <a href="<?=$variables['REGISTER_FINAL_CONFIRM_URL'];?>" onmouseover="this.style.color = '#EB8270';" onmouseout="this.style.color = '#0d2173';" style="color: #0d2173; text-decoration: none;"><?=$variables['REGISTER_FINAL_CONFIRM_URL'];?></a>
        </div>
	</div>
</div>