<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Kanacards</title>
        <link type="text/css" rel="stylesheet" href="/view/styles.css" />
    </head>
    <body>
        <header>
            <h1>Kanacards</h1>
        </header>
        
        <nav>
            <ul>
                <li><a href="#!display=drills">Drills</a></li>
                <li><a href="#!display=find">Find Card</a></li>
                <li><a href="#!display=add">Add Card</a></li>
                <li><a href="#!display=stats">Stats</a></li>
            </ul>
        </nav>
        
        <div id="addCard">
            <label for="txtWord">Foreign Word</label>
            <input type="text" name="txtWord" id="txtWord" />
            <label for="txtTranslation">Translation</label>
            <input type="text" name="txtTranslation" id="txtTranslation" />
            <button id="btnAdd">Add</button>
        </div>
        
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script type="text/javascript" src="/view/scripts.js"></script>
    </body>
</html>