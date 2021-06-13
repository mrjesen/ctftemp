#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include <string.h>
char v4[68];
char a1[68];
int main() {
	strcpy(v4, "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");
    int a;
	int v5;
	unsigned int v1;
	v1 = time(0);
    srand(v1);

    for (int i = 0; i <= 9; ++i )
  {
    v5 = rand() % 62;
    a1[i] = v4[v5];
  }
  printf("%s",a1);
}
