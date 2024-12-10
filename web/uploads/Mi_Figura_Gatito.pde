void setup(){
  size(250,250); // Fondo
  background(#0000FF);
}

void draw(){
  fill(#FFFFFF);
  triangle(50,50,50,90,90,60);
  triangle(150,50,150,90,110,60);
  fill(#FFCCCC);
  triangle(55,55,55,95,95,65);
  triangle(145,55,145,95,105,65);
  fill(#FFFFFF);
  ellipse(100,100,100,100);
  
  fill(#FFFFFF);
  arc(100, 116, 50, 30, 0, PI / 2.0);
  arc(75, 130, 50, 4, 0, PI / 2.0);
  fill(#000000);
  line(100,120,100,130);
  fill(#FFCCCC);
  triangle(95,110,105,110,100,120);
  
  fill(#000000);
  ellipse(80,90,20,20);
  ellipse(120,90,20,20);
  fill(#FFFFFF);
  ellipse(75,87,9,9);
  ellipse(115,87,9,9);
}
