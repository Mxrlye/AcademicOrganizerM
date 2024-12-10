
//int letra [7]={1,1,1,0,1,1,1}; //a b c d e f g 
int letra [7]={0,0,0,1,1,1,0}; //a b c d e f g 

void setup() {
for(int i=2; i<9; i++){
  pinMode(i,OUTPUT);
}


}

void loop() {
 for(int i=2; i<9; i++){
  digitalWrite(i,letra[i-2], HIGH);
  delay(500);
  
}

}