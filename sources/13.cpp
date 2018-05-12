//Task: game
//Author: Kinka Kirilowa-Lupanowa

#include <bits/stdc++.h>
using namespace std;

char s[100001];
void solve() 
{ cin>>s;
  int n = strlen(s);
  if (n % 2 == 0)
   {
     if (s[0] != '1') { cout<<1<<endl; return;}
     for (int i = 1; i < n; i += 2)
      {
        if (s[i] < '9') { cout<<2<<endl; return;}  
        if (s[i + 1] > '0') {cout<<1<<endl; return;}     
      }
     cout<<2<<endl; return;
   } 
   else 
   {
    for (int i = 0; i < n; i += 2) 
    {    
      if (s[i] < '9') {cout<<1<<endl; return;}
      if (s[i + 1] > '0') {cout<<2<<endl; return;}
        
    }
    cout<<1<<endl; return;
   }       
}

int main() 
{
ios_base::sync_with_stdio(0);
int k;
  cin>>k;
  for (int i = 0; i < k; i++)  solve();
  return 0;
}