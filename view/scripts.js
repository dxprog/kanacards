(function() {
    
    var
    
        el = {
            $btnAdd:$('#btnAdd'),
            $txtWord:$('#txtWord'),
            $txtTranslation:$('#txtTranslation')
        },
        
        page = {
            
            /**
             * Parameter stack from hash values
             */
            params:{},
            
            /**
             * Called when the user has initiated a page change (from hash)
             */
            dispatch:function(params) {
                
                var
                    i = null,
                    offset = null;
                
                // Push all the parameters onto the stack
                for (var i in params) {
                    if (params.hasOwnProperty(i)) {
                        page.params[i] = params[i];
                    }
                }
                
                // Check for a "display" parameter. This is our cue to change the "page"
                if (params.hasOwnProperty('display')) {
                    offset = $('#' + params.display).offset();
                    $('body').animate({ scrollTop:offset.top + 'px' });
                }
                
            }
        
        },
        
        hash = {
            
            previous:null,
            interval:null,
            
            /**
             * Timer callback that listens for changes in the hash value
             */
            listener:function() {
                var
                    params = [],
                    kvp = [],
                    dispatch = {},
                    count = 0,
                    i = 0;
                    
                if (window.location.hash !== hash.previous) {
                    params = window.location.hash.replace('#!', '').split('&');
                    for (count = params.length; i < count; i++) {
                        kvp = params[i].split('=');
                        if (kvp.length > 1) {
                            dispatch[kvp[0]] = kvp[1];
                        } else {
                            dispatch[kvp[0]] = true;
                        }
                    }
                    page.dispatch(dispatch);
                }
                
                hash.previous = window.location.hash;
            },
            
            init:$(function() {
                setInterval(hash.listener, 100);
            })
            
        }
        
        add = {
            /**
             * Click-event handler for add button
             */
            click:function(e) {
                if (el.$txtWord.val().length > 0 && el.$txtTranslation.val().length > 0) {
                    $.ajax({
                        url:'/cards/create/.json',
                        type:'POST',
                        dataType:'json',
                        data:{ word:el.$txtWord.val(), translation:el.$txtTranslation.val(), languageId:1 },
                        success:add.ajaxCallback
                    });
                }
            },
            
            /**
             * Handles response from server after adding a word
             */
            ajaxCallback:function(data) {
                if (data === true) {
                    el.$txtWord.val('').focus();
                    el.$txtTranslation.val('');
                }
            },
            
            /**
             * Sets up event callbacks. Self-executing
             */
            init:(function() {
                $(function() {
                    el.$btnAdd.on('click', add.click);
                });
            }())
            
        };

}());