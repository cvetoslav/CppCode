#include<bits/stdc++.h>
using namespace std;
bool f[1024];
int main(int argc,char* argv[])
{
    string out = argv[1], in = argv[2];
    stringstream sin(in);
    stringstream sout(out);
    int n,a,b,x;
    sin>>n>>a>>b; cerr<<out<<endl<<in<<endl;
    vector<int> v; int sz=0;
    while(sout>>x)
    {
        v.push_back(x); sz++;
        f[x]=1;
    }
    if(sz!=n) cout<<0<<endl;
    else
    {
        if(v[a]!=b){cout<<0<<endl; return 0;}
        for(int i=1;i<=n;i++)
            if(!f[i]){cout<<0<<endl; return 0;}
        cout<<1<<endl;
    }
    return 0;
}