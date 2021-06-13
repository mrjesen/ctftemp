from pycipher import ADFGVX
from itertools import permutations
from string import uppercase as _
 
def possible(a, b):
    for i in range(len(b)):
        for j in range(len(b)):
            if b[i] == b[j]:
                if a[i] <> a[j]:
                    return False
            if b[i] <> b[j]:
                if a[i] == a[j]:
                    return False
    return True
 
t = "VDFXXVFGAXAFVVDAFFXXFDXXXGXVVVDGAVGFFGFVGVXGFGFVFVGVGXGGXDFFAGXVAXFGFFDAVGFGGDVVAVVGDXGDGAAVGXDVFDDVDVFAVDFGFFDXDAGADAGFVDDGGXFVDVVFXGGVFAVDXXFXXVGVGGFXFXVVDGAGAVDXXAXAFFXGXVDAVFVXFGXFFXAVFGXVVVVVFVXFVXXGFVVVAFDDDGXGAADVXAGXXDAFGADXDXDFDXVGXVVGGGGVGGGXDVDDVFGVVVFFVAFVDGDFXDGXDVVDDAVVGAFDVXVGGVXGFDXDVXXXXXDAGGXADXGGGVDGDAVVXFVDFFXDGGFGDVDVDVFVGGXDFVGXDVAADADVVGDVXGXXDXAFDVAVVDDGVFXGVAXXGXVVDGFGFXXDFAGDFGFVFDAFVXGVVXAVGFFVVADAFVXVDVXVAXFGVGFFFAGAGVGDDDXAADVVXGGFFXVGXVXXFAGXGFDADDAFGFDAXGAFFDGXVXGAGVVDVXGVXXGVVVXFGGVVGAXX"
crib = "SHIPPINGORDERFROMBRAMBLOEMENDAALPHONE0123456789TOJORISVERHOVEN"
 
for p in permutations("ABCDE"):
    # We decipher the ciphertext with a random key - we will solve monosub later
    adfgvx = ADFGVX(key='PH0QG64MEA1YL2NOFDXKR3CVS5ZW7BJ9UTI8', keyword=''.join(p))
    d = adfgvx.decipher(t)
    if(possible(d[:len(crib)], crib)):
        print "Found"
        #print keyword
        print d