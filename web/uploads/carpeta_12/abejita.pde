//Dibujo de una abejita
void setup() {
  size(700, 700);
}

void draw() {
  background(159, 233, 255);

  float h = 350;
  float k = 150;
  float r = 80.0;
  int n = 6; // número de lados del polígono
  
  strokeWeight(4);
  poligono(h, k, r, n); // Dibujar polígono
  
  //-------------------------------------------------------
  
  strokeWeight(4);
  stroke(0, 0, 0); // Establecer el color de las rayas a negro
  fill(255, 255, 0); // Establecer el color de relleno a amarillo
  ellipse(width/2, height/2, 270, 270); // Dibujar círculo
  
  float x = width / 2;
  float y = height / 2;
  float radio = 135;
  float angleStep = 10; 
  
  for (float angle = 0; angle < 360; angle += angleStep) {
    float startX = x + radio * cos(radians(angle));
    float startY = y + radio * sin(radians(angle));
    float endX = x + radio * cos(radians(angle + angleStep));
    float endY = y + radio * sin(radians(angle + angleStep));
    line(startX, startY, endX, endY);
  }
  
  //------------------------------------------------------------
  
  int x1 = 258;
  int y1 = 250;
  int x2 = 440;
  int y2 = 250;
  
  stroke(0);
  strokeWeight(8);
  
  // Calcular la pendiente de la línea
  float m = (float)(y2 - y1) / (float)(x2 - x1);
  
  // Dibujar los puntos
  for (int i = x1; i <= x2; i++) {
    int a_y2 = round(m * (i - x1) + y1);
    point(i, a_y2);
  }
  
  //------------------------------------------------
  
  int x1_2 = 228;
  int y1_2 = 300;
  int x2_2 = 468;
  int y2_2 = 300;
  
  stroke(0);
  strokeWeight(8);
  
  // Calcular la pendiente de la línea
  float m_2 = (float)(y2_2 - y1_2) / (float)(x2_2 - x1_2);
  
  // Dibujar los puntos
  for (int i = x1_2; i <= x2_2; i++) {
    int b_y2 = round(m_2 * (i - x1_2) + y1_2);
    point(i, b_y2);
  }
  
  //--------------------------------------------------
  
  int x1_3 = 220;
  int y1_3 = 350;
  int x2_3 = 482;
  int y2_3 = 350;
  
  stroke(0);
  strokeWeight(8);
  
  // Calcular la pendiente de la línea
  float m_3 = (float)(y2_3 - y1_3) / (float)(x2_3 - x1_3);
  
  // Dibujar los puntos
  for (int i = x1_3; i <= x2_3; i++) {
    int c_y2 = round(m_3 * (i - x1_3) + y1_3);
    point(i, c_y2);
  }
  
  //-------------------------------------------------
  
  int x1_4 = 228;
  int y1_4 = 400;
  int x2_4 = 474;
  int y2_4 = 400;
  
  stroke(0);
  strokeWeight(8);
  
  // Calcular la pendiente de la línea
  float m_4 = (float)(y2_4 - y1_4) / (float)(x2_4 - x1_4);
  
  // Dibujar los puntos
  for (int i = x1_4; i <= x2_4; i++) {
    int d_y2 = round(m_4 * (i - x1_4) + y1_4);
    point(i, d_y2);
  }
  
  int x1_5 = 260;
  int y1_5 = 450;
  int x2_5 = 440;
  int y2_5 = 450;
  
  stroke(0);
  strokeWeight(8);
  
  // Calcular la pendiente de la línea
  float m_5 = (float)(y2_5 - y1_5) / (float)(x2_5 - x1_5);
  
  // Dibujar los puntos
  for (int i = x1_5; i <= x2_5; i++) {
    int e_y2 = round(m_5 * (i - x1_5) + y1_5);
    point(i, e_y2);
  }
  
  //--------------------------------------------------------
  
  float x_c = 275; // Coordenada x del centro del arco
  float y_c = 80; // Coordenada y del centro del arco
  float angulo_inicio = radians(285); // Ángulo de inicio del arco
  float angulo_final = radians(285 + 75); // Ángulo final del arco
  float rad = 60; // Radio del círculo
  noFill();
  stroke(0);
  strokeWeight(2);
  arc(x_c, y_c, rad*2, rad*2, angulo_inicio, angulo_final, OPEN); // Dibuja el arco
  
  //----------------------------------------------------------
  
  float x_c2 = 425; // Coordenada x del centro del arco
  float y_c2= 83; // Coordenada y del centro del arco
  float angulo_inicio2 = radians(185); // Ángulo de inicio del arco
  float angulo_final2 = radians(185 + 75); // Ángulo final del arco
  float rad2 = 60; // Radio del círculo
  noFill();
  stroke(0);
  strokeWeight(2);
  arc(x_c2, y_c2, rad2*2, rad2*2, angulo_inicio2, angulo_final2, OPEN); // Dibuja el arco
  
  //---------------------------------------------------------------------------
  
  stroke(0,0,0); // establece el color de la línea en negro
  strokeWeight(25); // establece el grosor de la línea 
  point(320, 130); // dibuja el punto en las coordenadas 
  
  //----------------------------------------------------------------------------
  
  stroke(0,0,0); // establece el color de la línea en negro
  strokeWeight(25); // establece el grosor de la línea en 
  point(380, 130); // dibuja el punto en las coordenadas 
  
  //---------------------------------------------------------------------------
  
  stroke(0,0,0); // establece el color de la línea en negro
  strokeWeight(10); // establece el grosor de la línea 
  point(350, 150); // dibuja el punto en las coordenadas 
  
  //----------------------------------------------------------------------------
  
  stroke(255,255,155); // establece el color de la línea en negro
  strokeWeight(5); // establece el grosor de la línea en 
  point(380, 130); // dibuja el punto en las coordenadas 
  
  //---------------------------------------------------------------------------
  
  stroke(255,255,255); // establece el color de la línea en negro
  strokeWeight(5); // establece el grosor de la línea 
  point(320, 130); // dibuja el punto en las coordenadas 
  
 //----------------------------------------------------------------------------
 
  float x_c3 = 350; // Coordenada x del centro del arco
  float y_c3 = 120; // Coordenada y del centro del arco
  float angulo_inicio3 = radians(55); // Ángulo de inicio del arco
  float angulo_final3 = radians(55 + 75); // Ángulo final del arco
  float rad3 = 60; // Radio del círculo
  noFill();
  stroke(0);
  strokeWeight(2);
  arc(x_c3, y_c3, rad3*2, rad3*2, angulo_inicio3, angulo_final3, OPEN); // Dibuja el arco
  
  //--------------------------------------------------------------------
  
  fill(255, 255, 255); // Color azul cielo
  triangle(80, 150, 200, 150, 253, 253);
  triangle(540, 150, 660, 150, 448, 253);
  
  //--------------------------------------------------------------------
  
  fill(0); // Color azul cielo
  triangle(340, 480, 360, 480, 350, 550);
}

//---------------------metodos-------------------------

void poligono(float h, float k, float r, int n) {
  float incang = 360.0 / n;
  float ang = 0;
  float xc = h + r;
  float yc = k;
  float x, y;

  for (int i = 0; i < n; i++) {
    ang += incang;
    x = h + r * cos(ang / 57.3);
    y = k + r * sin(ang / 57.3);
    line(xc, yc, x, y);
    xc = x;
    yc = y;
  }
  
  stroke(0);
  fill(255, 255, 0); // Establecer el color de relleno a amarillo
  beginShape(); // Comenzar a definir la forma del polígono
  for (int i = 0; i < n; i++) {
    ang += incang;
    x = h + r * cos(ang / 57.3);
    y = k + r * sin(ang / 57.3);
    vertex(x, y); // Añadir los vértices del polígono
  }
  endShape(CLOSE); // Finalizar la definición del polígono y cerrarlo
}
