import angr,claripy
def main():
    flag_chars = [claripy.BVS('flag_%d' % i,8) for i in range(38)]
    flag = claripy.Concat(*flag_chars + [claripy.BVV(b'\n')])
    p= angr.Project('./secret.exe',load_options={"auto_load_libs":False})
    state = p.factory.full_init_state(args=['./a.exe'],add_options=angr.options.unicorn,stdin=flag)
    sm = p.factory.simgr(state)
    def correct(state):
        try:
            return b'yeah' in state.osix.dumps(1)
        except:
            return False
    def wrong(state):
        try:
            return b'ohhh' in state.osix.dumps(1)
        except:
            return False
    sm.explore(find=0x14000170E,avoid=0x000000014000171C)
    if sm.found:
        find_state = sm.found[0]
    return find_state.posix.dumps(0)

print(repr(main()))