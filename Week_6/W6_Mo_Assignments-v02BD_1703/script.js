window.onload = function startGame(){

    document.getElementById("btn_set_disk_num")
            .addEventListener("click", function(){
                window.location.reload()
            });

    var disk_num = 5;

    // if( document.getElementById("disk_num_input").value){
    //     disk_num = document.getElementById("disk_num_input").value;
    // }

    var colors = ['rgb(120, 131, 182)',
                    'rgb(60, 74, 136)',
                    'rgb(38, 52, 114)',
                    'rgb(21, 34, 90)',
                    'rgb(9, 18, 59)',
                    'rgb(2, 9, 41)',
                    'rgb(44, 4, 56)',
                    'rgb(48, 2, 8)',
                    'rgb(0, 31, 4)',
                    'rgb(24, 44, 0)'];
    var poles = [ pole1 , pole2 ,pole3 ];
    var moves = [];
    // /var disk_num = 5;
    var SMALLEST_DISK_WIDTH = 50;
    var TOP_HEIGHT = 0;
    var DISK_HEIGHT = 30;

    function Hanoi(number, from,from_num, to ,to_num, via,via_num)
    {
            if (number==0) {
                return;
            }
            Hanoi(number-1, from,from_num, via,via_num , to,to_num);
            moves.push( {from: from_num, to: to_num} );
            Hanoi(number-1, via,via_num, to,to_num , from,from_num);
    }
    function resetStack(number)
    {
        poles[0] = [];
        poles[1] = [];
        poles[2] = [];
        var loop = function (i) {
            setTimeout( 
                    function(){
                        setTimeout( function(){
                                        if(i>0){
                                            poles[0].push(i);
                                            insertDisk(poles[0],1,i);
                                            printPole(poles[0]);
                                        }
                                    },1000);
                        if(i >= 0){
                        // printPole(pole1);
                            console.log("itteration number: "+i);
                            loop(--i);
                        }
                    },1000);
        };
        loop(number+1);
    }
    function printPole(pole)
    {
        let temp_pole = [];

        console.log("length of pole:" + pole.length);
        var len = pole.length;
        for( var i = 0; i < len; i++){
            var top = pole[pole.length-1];

            console.log(top);
            temp_pole.push(pole.pop());

        }
        console.log("-------");

        for( var i = 0; i < len; i++){
            pole.push(temp_pole.pop());
        }
    }
    function removeDisk(from_pole,from_pole_num,disk_num)
    {
        var disk = document.getElementById("pole"+from_pole_num+"disk"+disk_num);
        let disk_width = disk.offsetWidth;
        let disk_height = disk.offsetHeight;
        let plate_base = from_pole.length*disk_height ;
        let tempColor = colors[disk_num-1];

        let current_pole = document.getElementById("pole"+from_pole_num); 
        let full_pole_height = current_pole.offsetHeight;

        var pos = plate_base;
        var id = setInterval(frame, 3);
        function frame() {
            if (pos >= full_pole_height-DISK_HEIGHT) {
                clearInterval(id);
                disk.parentNode.removeChild(disk);
            } else {
                pos+=2; 
                disk.setAttribute(
                    "style",
                        "width: " + disk_width + "px;"+
                        "height: " + DISK_HEIGHT + "px;"+
                        "position: absolute;"+
                        "bottom: "+ pos +"px;"+
                        "left:50%;"+
                        "margin-left:-"+(disk_width/2)+"px;"+
                        "background-color: "+tempColor+";"+
                        "border-radius: 18px;"
                );
            }
        }
    }
    function insertDisk(to_pole,to_pole_num,disk_num)
    {
        //getting needed info for moving
        let disk_width = disk_num * SMALLEST_DISK_WIDTH;
        //let disk_height = 30; 
        let top_position_to_pole = to_pole.length * DISK_HEIGHT;
        let tempColor = colors[disk_num-1];

        //create the disk
        var disk = document.createElement("div");
        disk.setAttribute("id", "pole"+to_pole_num+"disk"+disk_num);
        disk.setAttribute(
            "style",
                "width: " + disk_width + "px;"+
                "height: " + DISK_HEIGHT + "px;"+
                "position: absolute;"+
                "top: "+ TOP_HEIGHT +"px;"+
                "left:50%;"+
                "margin-left:-"+(disk_width/2)+"px;"+
                "background-color: "+tempColor+";"+
                "border-radius: 18px;"
        );

        let current_pole = document.getElementById("pole"+to_pole_num); 
        current_pole.appendChild(disk);

        let full_pole_height = current_pole.offsetHeight;


        var pos = 0;
        var id = setInterval(frame, 2);
        function frame() {
            if (pos >= (full_pole_height - top_position_to_pole)) {
                clearInterval(id);
            } else {
                pos+=2; 
                //disk.style.top = pos + 'px'; 
                disk.setAttribute("style","width: " + disk_width + "px;"+
                "height: " + DISK_HEIGHT + "px;"+
                "position: absolute;"+
                "top: "+ pos +"px;"+
                "left:50%;"+
                "margin-left:-"+(disk_width/2)+"px;"+
                "background-color: "+tempColor+";"+
                "border-radius: 18px;");
            }
        }
    }
    function moveDisk (from_pole,from_pole_num,to_pole,to_pole_num)
    {
        let disk_num = from_pole[from_pole.length-1];

        setTimeout( 
                function(){
                    setTimeout( function(){
                                    insertDisk(to_pole,to_pole_num,disk_num);
                                },1000);
                    removeDisk(from_pole,from_pole_num,disk_num);    
                },1000);


        //pushing to second pole
        to_pole.push(from_pole.pop());
    
    }

    setTimeout( function(){
        setTimeout( function(){
            console.log(moves.length);
            console.log(moves);
            
            var loop = function (i) {
                setTimeout( 
                        function(){
                            setTimeout( function(){
                                        console.log("from: "+moves[i].from + " to :"+moves[i].to);
                                        moveDisk(poles[moves[i].from -1],
                                                moves[i].from ,
                                                poles[moves[i].to -1],
                                                moves[i].to );
                                        },1000);
                            if(i < moves.length -1 ){
                                console.log("itteration number: "+i);
                                loop(++i);
                            }
                },3000);
            };
            loop(-1);

        },1500);

        //get all the moves
        Hanoi(disk_num,poles[0],1,poles[1],2,poles[2],3);

    },600*disk_num);

    //start as reseted;
    resetStack(disk_num);
}
