import hashlib
def md5(s):
    md5 = hashlib.md5() 
    md5.update(s.encode("utf8")) 
    return md5.hexdigest()
def filehash():
    filename = '/fllllllllllllaaaaaag'
    cookie_secret = 'ef57c331-744f-4528-b434-9746317d4f6a'
    print(md5(cookie_secret+md5(filename)))

if __name__ == '__main__':
    filehash()