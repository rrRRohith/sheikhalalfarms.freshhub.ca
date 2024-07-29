<html>
    <head>
        <title>FreshHub</title>
        <link href="/css/style.css" rel="stylesheet" />
        <style>
            body {
                margin: 0px;
                height: 100vh;
                color: #444;
            }
            
            h1 img {
                max-width: 300px;
                height: auto;
                margin: 25px;
                
            }
            
            #container {
                display: flex;
                flex-direction: column;
                align-items: stretch;
                justify-content: stretch;
                height: 100vh;
            }
            
            header {
                text-align: center;
            }
            
            footer {
                display: flex;
                flex-direction: column;
                justify-content: end;
            }
            
            main {
                width: 100%;
                display: flex;
                flex-direction: column;
                align-items:center;
                flex-grow:3;
                padding: 50px 0px;
            }
            
            h2 {
                font-weight: 400;
                font-size: 500%;
                
            }
            
            h3 {
                 font-weight: 400;
                font-size: 300%;
                color: #cc615a;
            }
            
        </style>
    </head>
    <body>
        <div id="container">
            <header>
                <h1><img src="/img/freshhub_logo.png" alt="FreshHub" /></h1>
            </header>
            <main>
                <h2>Oop!</h2>
                <h3>The page requested doesn't exist...</h3>
                <p>We're sorry. The Web address you entered is not a functioning page on our site</p>
                <p>Go to Freshhub's <a href="/">Home page</a></p>
            </main>
            <footer>
                <p>&copy; 2021 FreshHub, All rihgts are reseved.</p>
            </footer>
        </div>
        
    </body>
</html>