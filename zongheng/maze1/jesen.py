#coding: utf-8
from pwn import *
dirs=[(0,1),(1,0),(0,-1),(-1,0)] #当前位置四个方向的偏移量
d =  ['w','a','s','d']
path=[]              #存找到的路径
 
def mark(maze,pos):  #给迷宫maze的位置pos标"2"表示“倒过了”
    maze[pos[0]][pos[1]]=2
 
def passable(maze,pos): #检查迷宫maze的位置pos是否可通行
    return maze[pos[0]][pos[1]]==0
 
def find_path(maze,pos,end):
    mark(maze,pos)
    if pos==end:
        path.append(pos)
        return True
    for i in range(4):
        nextp=pos[0]+dirs[i][0],pos[1]+dirs[i][1]
        if passable(maze,nextp):
            if find_path(maze,nextp,end):
                path.append(d[i])
                return True
    return False
 

if __name__ == '__main__':
    r = remote("182.92.203.154",11001)
    r.recvuntil("start")
    r.send("k")
    tmp = r.recvuntil(">")[:-1]
    path = []
    tmp1 = tmp.split("\n")
    for i in range(len(tmp1)):
        tmp[i] = tmp[i].split("")
        count = 0
        for e in range(len(tmp[i])):
            if tmp[i][e] == '#':
                tmp[i][e] = 1
            elif tmp[i][e] == ' ':
                tmp[i][e] = 0
            elif tmp[i][e] == '*':
                tmp[i][e] = 0
                start = (i,e)
            elif tmp[i][e] == '$':
                tmp[i][e] = 0
                end = (i,e)
        find_path(tmp,start,end)