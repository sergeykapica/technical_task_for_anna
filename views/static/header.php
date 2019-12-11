<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="keywords" content="<?=$keywords;?>" />
        <?if(isset($stylesList) && !empty($stylesList)):?>
            <?foreach($stylesList as $style):?>
                <link rel="stylesheet" type="text/css" href="/sources/css/<?=$style;?>.css">
            <?endforeach;?>
        <?endif;?>
        <link rel="shortcut icon" href="/favicon.png" type="image/png">
        <title><?=$title;?></title>
    </head>
    <body>
        <div id="main-wrapper">
            <header id="main-header">
                <div class="main-header-left">
                    <h3 class="main-logotype">Technical-task-for-anna.com</h3>
                </div>
                <div class="main-header-right">
                    <div class="authorizate-button-wrapper">
                        <button title="<?=GetMessage('LANGUAGE_CHOICE');?>" class="lang-change-button div-select lc-icon-close dropdown-additional-methods"></button>
                        <?if(!isset($userAuthorized)):?>
                            <button class="authorizate-button">
                                <span><?=GetMessage('AUTHORIZATE_BUTTON_TITLE');?></span>
                                <div class="animate-band"></div>
                            </button>
                        <?else:?>
                            <a href="/personal/get_out_private_zone" class="authorizate-button authorizate-button-link">
                                <span><?=GetMessage('AUTHORIZATE_BUTTON_EXIT');?></span>
                                <div class="animate-band"></div>
                            </a>
                        <?endif;?>
                        
                        <?if(isset($languagesList)):?>
                            <ul class="div-select-list">
                                <?foreach($languagesList as $language):?>
                                    <li class="div-select-item"><a href="<?=$language['CODE_URL'];?>" class="language-link"><?=$language['NAME'];?></a></li>
                                <?endforeach;?>
                            </ul>
                        <?endif;?>
                    </div>
                </div>
            </header>
            <div id="main-content">
                <div class="bread-crumb-wrapper"><?=$breadCrumbString;?></div>
            
            