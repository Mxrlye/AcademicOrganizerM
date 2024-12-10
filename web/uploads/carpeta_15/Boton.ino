int EntradaDigital= 12;
int LedSalida= 7;
void setup() {
  
pinMode(LedSalida,OUTPUT);
pinMode(EntradaDigital,INPUT);

}

void loop() {

if(digitalRead(EntradaDigital)==0)
 digitalWrite(LedSalida, HIGH);
 else
 digitalWrite(LedSalida, LOW);


}
