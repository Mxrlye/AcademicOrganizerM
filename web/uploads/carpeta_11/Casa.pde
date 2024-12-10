void setup(){
  size(700,500); // Fondo
  background(#5F84D1);
}

void draw(){
  //Casa
  fill(#F2E395);
  rect(250,200,100,100);
  rect(350,200,100,100);
  fill(#9B6610);
  rect(270,230,50,70); //Puerta de la casa
  //Techo de la casa
  fill(#FF0000);
  triangle(250,200,300,125,350,200);
  quad(300,125,412,125,450,200,350,200);
  //Chimenea
  fill(#FF8000);
  rect(360,90,20,70);
  fill(#CCCCCC);
  rect(355,80,30,15);
  //Sol
  fill(#F5FC2E);
  ellipse(580,70,100,100);
  //Pasto
  fill(#2F9B2F);
  rect(0,300,750,750);
   //Arbol
  fill(#804000);
  rect(90,200,20,100);
  fill(#4DB920);
  triangle(50,200,100,100,150,200);
  fill(#4DB920);
  triangle(50,175,100,100,150,175);
  fill(#4DB920);
  triangle(50,145,100,100,150,145);
}
