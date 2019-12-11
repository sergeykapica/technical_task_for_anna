<?if($variables['SEND'] === true):?>

    <div class="email-result" id="email-result-success">
        <div class="result-icon" id="result-icon-success"></div>
        <p id="result-text"><?printf($variables['SEND_RESULT_TEXT'], $variables['USER_EMAIL']);?></p>
    </div>

<?else:?>

    <div class="email-result" id="email-result-error">
        <div class="result-icon" id="result-icon-error"></div>
        <p id="result-text"><?=$variables['SEND_RESULT_TEXT'];?></p>
    </div>

<?endif;?>