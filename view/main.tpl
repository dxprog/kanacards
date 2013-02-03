<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="initial-scale=1.0, width=device-width, height=device-height, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Kanacards</title>
        <link type="text/css" rel="stylesheet" href="/view/styles.css?20130130" />
    </head>
    <body>
        <header>
            <h1>Kanacards</h1>
        </header>
        <div id="menus">
            <section id="main">
                <nav>
                    <ul>
                        <li><a href="#!display=drills">Drills</a></li>
                        <li><a href="#!display=find">Find Card</a></li>
                        <li><a href="#!display=add">Add Card</a></li>
                        <li><a href="#!display=stats">Stats</a></li>
                    </ul>
                </nav>
            </section>
            
            <section id="drills">
                <h2>Drills</h2>
                <nav>
                    <ul>
                        <li><a href="#!type=random&display=mode">Random Cards</a></li>
                        <li><a href="#!type=new&display=mode">New Cards</a></li>
                        <li><a href="#!type=trouble&display=mode">Trouble Cards</a></li>
                        <li><a href="#!display=main">Back</a></li>
                    </ul>
                </nav>
            </section>
            
            <section id="mode">
                <h2 id="hdrType"></h2>
                <nav>
                    <ul>
                        <li><a href="#!mode=read&display=game">Read</a></li>
                        <li><a href="#!mode=translate&display=game">Translate</a></li>
                        <li><a href="#!display=drills">Back</a></li>
                    </ul>
                </nav>
            </section>
        </div>
        
        <section id="add">
            <h2>Add Card</h2>
            <label for="txtWord">Foreign Word</label>
            <input type="text" name="txtWord" id="txtWord" />
            <label for="txtTranslation">Translation</label>
            <input type="text" name="txtTranslation" id="txtTranslation" />
            <button id="btnAdd">Add</button>
        </section>
        
        <section id="game">
            <div class="word"></div>
            <label for="txtAnswer">Answer</label>
            <input type="text" name="txtAnswer" id="txtAnswer" />
            <button id="btnAnswer">Go</button>
            <button id="btnSkip">Unsure</button>
        </section>
        
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="/view/scripts.js?20130130"></script>
    </body>
</html>