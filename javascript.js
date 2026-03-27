function setup() {
            var canvas = document.getElementById('lessonCanvas');
            if (canvas.getContext) {
                var ctx = canvas.getContext('2d');

                //step 1
                ctx.strokeRect(0, 0, 100, 100);

                //step 2
                ctx.moveTo(20, 20);
                ctx.lineTo(50, 50);
                ctx.lineTo(60, 70);
                ctx.lineTo(70, 70);                
                ctx.lineTo(70, 70);
                ctx.lineTo(79, 79);
                ctx.stroke();

                //step 3
                ctx.fillStyle = 'rgb(255,0,0)';
                ctx.beginPath(); //step 4
                ctx.arc(100, 100, 16, 0, Math.PI * 2, false);
                ctx.fill();
                ctx.stroke(); //step 5

                //step 6 - copy and change angle and anticlockwise
                ctx.beginPath();                
                ctx.arc(70, 70, 16, 0, Math.PI, true);
                ctx.fill();
            }
        }