(function() {
    
    var
    
        el = {
            $btnAdd:$('#btnAdd'),
            $txtWord:$('#txtWord'),
            $txtTranslation:$('#txtTranslation'),
            $hdrType:$('#hdrType'),
            $menus:$('#menus'),
            $game:$('#game'),
            $txtAnswer:$('#txtAnswer'),
            $btnAnswer:$('#btnAnswer'),
            $btnSkip:$('#btnSkip')
        },
        
        controllers = {
            
            drills:function(stack) {
                
            },
            
            mode:function(stack) {
                
                if (stack.hasOwnProperty('type')) {
                    el.$hdrType.html(stack.type);
                    el.$menus.find('#mode a').each(function() {
                        this.setAttribute('href', this.getAttribute('href') + '&type=' + stack.type);
                    });
                }
                
            },
            
            game:function(stack) {
                
                var
                    
                    cards = [],
                    currentCard = 0,
                    mode = null,
                    
                    submitAnswer = function(correct) {
                        $.ajax({
                            url:'/cards/answer/.json',
                            type:'post',
                            dataType:'json',
                            data:{ cardId:cards[currentCard].id, correct:correct ? 'true' : 'false' }
                        });
                    },
                    
                    displayCard = function(index) {
                        if (index < cards.length) {
                            el.$game.removeClass('error').removeClass('correct');
                            el.$game.find('.word').html(cards[index].word);
                            el.$txtAnswer.val('').focus();
                        } else {
                            window.location.href = '#display=main';
                        }
                    },
                    
                    answerClick = function(e) {
                        
                        var correct = false;
                        
                        if (mode === 'read') {
                            if (el.$txtAnswer.val().toLowerCase() === cards[currentCard].translation.toLowerCase()) {
                                el.$game.removeClass('error').addClass('correct');
                                if (currentCard >= cards.length) {
                                    
                                } else {
                                    setTimeout(function() { displayCard(++currentCard); }, 1500);
                                }
                                correct = true;
                            } else {
                                el.$game.removeClass('error').addClass('error');
                            }
                        }
                        
                        submitAnswer(correct);
                        
                    },
                    
                    skipClick = function(e) {
                        submitAnswer(false);
                        if (mode === 'read') {
                            el.$game.find('.word').html(cards[currentCard].translation);
                            setTimeout(function() { displayCard(++currentCard); }, 3000);
                        }
                    },
                    
                    ajaxCallback = function(data) {
                        if (data.length > 0) {
                            cards = data;
                            currentCard = 0;
                            displayCard(currentCard);
                        }
                    },
                    
                    init = (function() {
                        
                        mode = stack.mode;
                        el.$menus.hide();
                        el.$game.show();
                        $.ajax({
                            url:'/cards/drill/.json?type=' + stack.type,
                            dataType:'json',
                            success:ajaxCallback
                        });
                        el.$btnAnswer.on('click', answerClick);
                        el.$btnSkip.on('click', skipClick);
                        
                    }());
            
            }
            
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
                    $('section').hide();
                    $('#' + params.display).show();
                    
                    // Check to see if there is a controller for this
                    if (controllers.hasOwnProperty(params.display)) {
                        controllers[params.display](page.params);
                    }
                    
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