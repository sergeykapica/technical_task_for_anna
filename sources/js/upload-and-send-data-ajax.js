(function()
{
    function uploadAndSendData(url, data, oSuccess, transferType = 'POST')
    { 
        oSuccess.loader.style.display = 'block';
        
        var xhr = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        
        oSuccess.xhr = xhr;
        
        if(xhr.onload !== undefined)
        {
            xhr.onload = function()
            {
                oSuccess.success();
            };
        }
        else
        {
            xhr.onreadystatechange = function()
            {
                if (this.readyState == 4 && this.status == 200) {
                    oSuccess.success();
                }
            };
        }
        
        xhr.open(transferType, url, true);
        xhr.send(data);
    }
    
    window.uploadAndSendData = uploadAndSendData;
})();