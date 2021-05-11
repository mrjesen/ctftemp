#!/usr/bin/env python3

from decimal import *
import math
import random
import struct
flag = "flag{asbhfjsjkw3r3jtn4kjgernjkfnbkjdsnbrkgh4oee}"

assert (len(flag) == 48)
msg1 = flag[:24]
msg2 = flag[24:]

primes = [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71, 73, 79, 83, 89]

getcontext().prec = 100
keys = []
sum_ = Decimal(0.0)
for i, c in enumerate(msg1):
    sum_ += c * Decimal(keys[i])

ct = math.floor(sum_ * 2 ** 256)
print(ct)

sum_ = Decimal(0.0)
for i, c in enumerate(msg2):
    sum_ += c * Decimal(keys[i])

ct = math.floor(sum_ * 2 ** 256)
print(ct)
