function setup() {
            var canvas = document.getElementById('lessonCanvas');
            if (canvas.getContext) {
                var ctx = canvas.getContext('2d');

                //step 1
                ctx.strokeRect(0, 0, 300, 300);

                //step 2
                ctx.moveTo(20, 20);
                ctx.lineTo(100, 100);
                ctx.lineTo(80, 200);
                ctx.lineTo(200, 80);                
                ctx.lineTo(200, 200);
                ctx.lineTo(280, 280);
                ctx.stroke();

                //step 3
                ctx.fillStyle = 'rgb(255,0,0)';
                ctx.beginPath(); //step 4
                ctx.arc(100, 100, 16, 0, Math.PI * 2, false);
                ctx.fill();
                ctx.stroke(); //step 5

                //step 6 - copy and change angle and anticlockwise
                ctx.beginPath();                
                ctx.arc(170, 170, 16, 0, Math.PI, true);
                ctx.fill();
            }
        }