#include<bits/stdc++.h>
using namespace std;
int main()
{
    vector<int> v;
    int n,a,b;
    cin>>n>>a>>b;
    for(int i=1;i<=n;i++) v.push_back(i);
    swap(v[a],v[b-1]);
    for(int i=0;i<n-1;i++) cout<<v[i]<<" "; cout<<v[n-1]<<endl;
    return 0;
}