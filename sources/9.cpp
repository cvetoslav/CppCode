#include<bits/stdc++.h>
using namespace std;
int main()
{
int N;
cin>>N;
for(int I=0;I<N;I++)
{
string s;
cin>>s;
int n=s.size();
if(n%2) cout<<(s[0]=='9'?"1":"2")<<endl;
else cout<<(s[0]=='1'?"2":"1")<<endl;
}
return 0;
}
