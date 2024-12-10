void setup() {
  size(600, 600);
}

void draw() {
  background(#AAD6DE);
  
  // Caparazon de la TORTUGA (cafe claro)
  fill(95, 47, 1);
  quad(120, 300, 250, 430, 380, 300, 250, 170);

  // Cabeza de la tortuga (verde claro)
  fill(252, 247, 156);
  quad(380, 300, 455, 375, 530, 300, 455, 225);

  // Piernas traseras (verde claro)
  fill(76, 183, 105);
  triangle(20, 160, 170, 254, 120, 154);
  triangle(20, 430, 170, 350, 120, 434);
  
  // Brazos (verde claro)
  triangle(333, 350, 380, 450, 310, 514);
  quad(383, 50, 313, 170, 333, 252, 403, 135);
}
