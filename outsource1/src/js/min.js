var isMinimum = 1;
var zoom    =100;
//Draw Reactangles



const canvas = document.getElementById('canv');
const ctx = canvas.getContext('2d');

//Tip
const tipCanvas = document.getElementById("tip");
const tipCtx = tipCanvas.getContext("2d");

/*rect 1 */
const rect1 = new Path2D();
rect1.rect(10, 0, 120, 10);
draw(rect1);

function draw(r){
    ctx.lineWidth = 2;
    ctx.strokeStyle = 'red';
    ctx.stroke(r);
}
function drawtip(r){
    ctx.lineWidth = 1;
    ctx.strokeStyle = 'redblack';
    ctx.stroke(r);
}

// Listen for mouse moves
canvas.addEventListener('mousedown', function(event) {
    // Check whether point is inside circle
    var tt = document.getElementById("tooltip");
    if (ctx.isPointInPath(rect1, event.offsetX, event.offsetY)) {
        console.log("lee");
        tt.style.display = "block";
        console.log(rect1.posX);
        tt.style.left= event.offsetX +'px';
        tt.style.top= event.offsetY-10 +'px';
    }
    else{
        tt.style.display = "none";  
    }
   
    
    
    
  });



function fullscreen(){
    var com = document.getElementById("component");
    if(isMinimum){
        com.classList.remove("minimum");
        com.classList.add("fullscreen");
        isMinimum = 0;
    }else{
        com.classList.add("minimum");
        com.classList.remove("fullscreen");
        isMinimum = 1;
    }
}
function zoomIn(){
    var img = document.getElementById("imgframe");
   if(zoom<=300){
    zoom += 5;
    img.style.width = zoom + '%';

   }
   
    
}
function zoomOut(){
    var img = document.getElementById("imgframe");
   if(zoom>100){
    zoom -= 5;
    img.style.width = zoom + '%';

   }
   
    
}
