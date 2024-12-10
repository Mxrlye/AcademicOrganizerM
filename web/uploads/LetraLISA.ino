
int letra [7]={0,0,0,1,1,1,0}; //a b c d e f g 
int letra2[7]={0,0,0,0,1,1,0};
int letra3[7]={1,0,1,1,0,1,1};
int letra4[7]={1,1,1,0,1,1,1};

void setup() {
for(int i=2; i<9; i++){
  pinMode(i,OUTPUT);
}


}

void loop() {
 for(int i=2; i<9; i++){
  digitalWrite(i,letra[i-2]);
}
delay(500);
for(int i=2; i<9; i++){
  digitalWrite(i,letra2[i-2]);
}
delay(500);
for(int i=2; i<9; i++){
  digitalWrite(i,letra3[i-2]);
}
delay(500);
for(int i=2; i<9; i++){
  digitalWrite(i,letra4[i-2]);
}
delay(500);

}
