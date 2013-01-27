(function() {

    $('#btnAdd').on('click', function(e) {
    
        var
            word = $('#txtWord').val(),
            translation = $('#txtTranslation').val(),
            
            ajaxCallback = function() {
                
                if (4 === this.readyState) {
                    var retVal = JSON.parse(this.responseText);
                    if (true === retVal) {
                        $('#txtTranslation').val('')
                        $('#txtWord').val('').focus();
                    }
                }
                
            };
            
        if (word.length > 0 && translation.length > 0) {
            
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '/cards/create/.json', true);
            xhr.onreadystatechange = ajaxCallback;
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.send('word=' + encodeURIComponent(word) + '&translation=' + encodeURIComponent(translation) + '&languageId=1');
            
        }
    
    });

}());