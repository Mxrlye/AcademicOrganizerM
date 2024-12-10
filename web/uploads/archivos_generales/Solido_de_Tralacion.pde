void setup() {
  size(600, 600, P3D);  // Establece el tamaño de la ventana de visualización 3D
}

void draw() {
  background(#FFF7F7);  // Establece el color de fondo a negro
  lights();  // Activa la iluminación en la escena
  
  translate(200, height/2, 0);  // Translada el punto inicial al punto (200, height/2, 0)
  
  rotateX(frameCount * 0.01);  // Rota la escena en el eje X en función del número de cuadros procesados hasta ahora
  
  for (int i = 0; i < 2; i++) {  // Repite el siguiente bloque de código dos veces
    translate(90, 00, 0);  // Translada el sistema de coordenadas en el eje X en 80 unidades
    drawCylinder(230, 90);  // Llama a la función drawCylinder() con los valores de altura y radio especificados
  }
}

void drawCylinder(float height, float radius) {
  stroke(255,81,176);  // Establece el color de línea a un tono de rosa
  
  int numPoints = 8;  // Número de puntos utilizados para aproximar el cilindro
  float angleIncrement = TWO_PI / numPoints;  // Incremento angular para cada punto
  
  for (int i = 0; i < numPoints; i++) {  // Repite el siguiente bloque de código para cada punto
    float y = cos(i * angleIncrement) * radius;  // Calcula la coordenada Y del punto
    float z = sin(i * angleIncrement) * radius;  // Calcula la coordenada Z del punto
    float x1 = -height/2;  // Establece la coordenada X del primer extremo de la línea
    float x2 = height/2;  // Establece la coordenada X del segundo extremo de la línea
    line(x1, y, z, x2, y, z);  // Dibuja una línea desde el primer extremo al segundo extremo
  }
  
  beginShape();  // Inicia una forma para dibujar los lados del cilindro
  for (int i = 0; i < numPoints; i++) {  // Repite el siguiente bloque de código para cada punto
    float y = cos(i * angleIncrement) * radius;  // Calcula la coordenada Y del punto
    float z = sin(i * angleIncrement) * radius;  // Calcula la coordenada Z del punto
    vertex(-height/2, y, z);  // Agrega un vértice a la forma en la coordenada especificada
  }
  endShape(CLOSE);  // Finaliza la forma y la cierra, creando una superficie cerrada
  
  beginShape();  // Inicia una nueva forma para dibujar las tapas del cilindro
  for (int i = 0; i < numPoints; i++) {  // Repite el siguiente bloque de código para cada punto
    float y = cos(i * angleIncrement) * radius;  // Calcula la coordenada Y del punto
    float z = sin(i * angleIncrement) * radius;  // Calcula la coordenada Z del punto
    vertex(height/2, y, z);  // Agrega un vértice a la forma en la coordenada especificada
  }
  endShape(CLOSE);  // Finaliza la forma y la cierra, creando una superficie cerrada
}
