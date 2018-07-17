<!DOCTYPE HTML>
<!--
   Radius by TEMPLATED
   templated.co @templatedco
   Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
  <head>
    <title>Detail 1 - Radius by TEMPLATED</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="main.css" />
  </head>
  <body>
    <script src="https://code.createjs.com/1.0.0/createjs.min.js"></script>
    <script src="https://code.createjs.com/easeljs-0.8.2.min.js"></script>
    <canvas id="demoCanvas" width="500" height="300"></canvas>

      <!-- Header -->
    <header id="header" class="preview">
      <div class="inner">
         <div class="content">
            <h1>Radius</h1>
            <h2>A fully responsive masonry style portfolio template.</h2>
         </div>
         <a href="index.html" class="button hidden"><span>Let's Go</span></a>
      </div>
    </header>

      <!-- Main -->
    <div id="preview">
      <div id="slider">
        <form>
          <label>Easy</label>
          <input type="range" id="scale" value="4" min="3" max="6" step="1">
          <label>Hard</label>
        </form>
        <br>
      </div>
      <div id="main" class="main">
        <canvas id="puzzle" width="480px" height="480px"></canvas>
      </div>
      <a href="detail1.html" class="nav previous"><span class="fa fa-chevron-left"></span></a>
      <a href="detail2.html" class="nav next"><span class="fa fa-chevron-right"></span></a>
    </div>

      <!-- Footer -->
    <footer id="footer">
      <a href="#" class="info fa fa-info-circle"><span>About</span></a>
      <div class="inner">
         <div class="content">
            <h3>Vestibulum hendrerit tortor id gravida</h3>
            <p>In tempor porttitor nisl non elementum. Nulla ipsum ipsum, feugiat vitae vehicula vitae, imperdiet sed risus. Fusce sed dictum neque, id auctor felis. Praesent luctus sagittis viverra. Nulla erat nibh, fermentum quis enim ac, ultrices euismod augue. Proin ligula nibh, pretium at enim eget, tempor feugiat nulla.</p>
         </div>
         <div class="copyright">
            <h3>Follow me</h3>
            <ul class="icons">
               <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
               <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
               <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
               <li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
            </ul>
            &copy; Untitled. Design: <a href="https://templated.co">TEMPLATED</a>. Images: <a href="https://unsplash.com/">Unsplash</a>.
         </div>
      </div>
    </footer>

      <!-- Scripts -->
    <!--<script src="js/jquery.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/util.js"></script>
    <script src="js/main.js"></script>-->
  </body>
  <script>
    function ScaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {

        var result = { width: 0, height: 0, fScaleToTargetWidth: true };

        if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {
            return result;
        }

        // scale to the target width
        var scaleX1 = targetwidth;
        var scaleY1 = (srcheight * targetwidth) / srcwidth;

        // scale to the target height
        var scaleX2 = (srcwidth * targetheight) / srcheight;
        var scaleY2 = targetheight;

        // now figure out which one we should use
        var fScaleOnWidth = (scaleX2 > targetwidth);
        if (fScaleOnWidth) {
            fScaleOnWidth = fLetterBox;
        }
        else {
           fScaleOnWidth = !fLetterBox;
        }

        if (fScaleOnWidth) {
            result.width = Math.floor(scaleX1);
            result.height = Math.floor(scaleY1);
            result.fScaleToTargetWidth = true;
        }
        else {
            result.width = Math.floor(scaleX2);
            result.height = Math.floor(scaleY2);
            result.fScaleToTargetWidth = false;
        }
        result.targetleft = Math.floor((targetwidth - result.width) / 2);
        result.targettop = Math.floor((targetheight - result.height) / 2);

        return result;
    }
  </script>
  <script>
    var cv = document.getElementById("puzzle");
    var context = cv.getContext("2d");
    var boardSize = document.getElementById("puzzle").width;
    var tileCount = document.getElementById('scale').value;
    var tileSize = boardSize / tileCount;

    var image = new Image();
    var imagePieces = new Array(tileCount);
    //image.onload = cutImageUp;
    var loaded = false;
    image.onload = function () {
      if (loaded)
        return;
      context.drawImage(this, 0, 0, this.width, this.height, 0, 0, cv.width, cv.height);
      this.src = cv.toDataURL();
      setBoard();
      drawTiles();
      loaded = true;
    };
    image.crossOrigin="anonymous";
    image.src = <? echo $_POST["src"] ?>;
    //image.src = 'https://www.bing.com/th?id=OIP.tMR2KJYFEEHS1zZ0-fP9SwHaFj&w=237&h=173&c=7&o=5&pid=1.7'

    function cutImageUp() {
      for(var x = 0; x < tileCount; ++x) {
        imagePieces[x] = new Array(tileCount);
        for(var y = 0; y < tileCount; ++y) {
            var canvas = document.createElement('canvas');
            canvas.width = tileSize;
            canvas.height = tileSize;
            var context = canvas.getContext('2d');
            context.drawImage(image, x * tileSize, y * tileSize, tileSize, tileSize, 0, 0, canvas.width, canvas.height);
            imagePieces[x][y] = canvas.toDataURL();
        }
      }
    }

    var boardParts = new Object;
    var solved = false;

    var clickLoc = new Object;
    clickLoc.x = 0;
    clickLoc.y = 0;

    var emptyLoc = new Object;
    emptyLoc.x = 0;
    emptyLoc.y = 0;

    document.getElementById('scale').onchange = function() {
      tileCount = this.value;
      tileSize = boardSize / tileCount;
      setBoard();
      drawTiles();
    };

    document.getElementById('puzzle').onmousemove = function(e) {
      clickLoc.x = Math.floor((e.pageX - this.offsetLeft) / tileSize);
      clickLoc.y = Math.floor((e.pageY - this.offsetTop) / tileSize);
    };

    document.getElementById('puzzle').onclick = function() {
      if (distance(clickLoc.x, clickLoc.y, emptyLoc.x, emptyLoc.y) == 1) {
        slideTile(emptyLoc, clickLoc);
        drawTiles();
      }
      if (solved) {
        setTimeout(()=>alert("You solved it!"), 500);
      }
    };

    function distance(x1, y1, x2, y2) {
      return Math.abs(x1 - x2) + Math.abs(y1 - y2);
    }

    function setBoard() {
      boardParts = new Array(tileCount);
      for (var i = 0; i < tileCount; ++i) {
        boardParts[i] = new Array(tileCount);
        for (var j = 0; j < tileCount; ++j) {
          boardParts[i][j] = new Object;
          boardParts[i][j].x = (tileCount - 1) - i;
          boardParts[i][j].y = (tileCount - 1) - j;
        }
      }
      emptyLoc.x = boardParts[tileCount - 1][tileCount - 1].x;
      emptyLoc.y = boardParts[tileCount - 1][tileCount - 1].y;
      solved = false;
    }

    function drawTiles() {
      context.clearRect ( 0 , 0 , boardSize , boardSize );
      for (var i = 0; i < tileCount; ++i) {
        for (var j = 0; j < tileCount; ++j) {
          var x = boardParts[i][j].x;
          var y = boardParts[i][j].y;
          if(i != emptyLoc.x || j != emptyLoc.y || solved == true) {
            context.drawImage(image, x * tileSize, y * tileSize, tileSize, tileSize, i * tileSize, j * tileSize, tileSize, tileSize);
          }
        }
      }
    }

    function slideTile(toLoc, fromLoc) {
      if (!solved) {
        boardParts[toLoc.x][toLoc.y].x = boardParts[fromLoc.x][fromLoc.y].x;
        boardParts[toLoc.x][toLoc.y].y = boardParts[fromLoc.x][fromLoc.y].y;
        boardParts[fromLoc.x][fromLoc.y].x = tileCount - 1;
        boardParts[fromLoc.x][fromLoc.y].y = tileCount - 1;
        toLoc.x = fromLoc.x;
        toLoc.y = fromLoc.y;
        checkSolved();
      }
    }

    function checkSolved() {
      var flag = true;
      for (var i = 0; i < tileCount; ++i) {
        for (var j = 0; j < tileCount; ++j) {
          if (boardParts[i][j].x != i || boardParts[i][j].y != j) {
            flag = false;
          }
        }
      }
      solved = flag;
    }
  </script>
</html>
