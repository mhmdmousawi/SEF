

var pole1 = [];     
var pole2 = [];
var pole3 = [];

function Hanoi(number, from, to , via)
{
    if (number==0) {
        return;
    }
    Hanoi(number-1, from, via , to);
    moveDisk(from,to);
    Hanoi(number-1, via, to , from);
}

function resetStack(number)
{
    for( var i = number; i > 0; i--){
        pole1.push(i);
    }
    pole2 = [];
    pole3 = [];
}

function printPole(pole)
{
    let tempPole = [];
    console.log("length of pole:" + pole.length);
    var len = pole.length;
    for( var i = 0; i < len; i++){
        var top = pole[pole.length-1];
        console.log(top);
        tempPole.push(pole.pop());
    }
    console.log("-------");

    for( var i = 0; i < len; i++){
        pole.push(tempPole.pop());
    }
}

function moveDisk (from,to)
{
    to.push(from.pop());
    from.push();
}

resetStack(5);

//print
printPole(pole1);
printPole(pole2);
printPole(pole3);

Hanoi(5,pole1,pole3,pole2);

//print
printPole(pole1);
printPole(pole2);
printPole(pole3);

resetStack(5);

//print
printPole(pole1);
printPole(pole2);
printPole(pole3);
