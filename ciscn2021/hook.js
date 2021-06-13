// /data/data/frida
//nox_adb forward tcp:27042 tcp:27042
//nox_adb forward tcp:27043 tcp:27043

//frida -U com.ciscn.glass -l hook.js


// var libhm = Process.findModuleByName("libnative-lib.so");
if (libhm != undefined) {
    var modulebase = libhm.base;
    console.log("base:" + modulebase);
    var sub_E018 = modulebase.add(0xC101088);
    var sub_E56C = modulebase.add(0xC1010D4);
    var sub_E7F8 = modulebase.add(0xC1010D4);

    Interceptor.attach(sub_E018, {
        onEnter: function (args) {
            console.log('1a')
            console.log(Memory.readCString(args[0]));
        },
        onLeave: function (retval) {
            console.log('1r')
            console.log("retval:"+retval);
            //Memory.readUtf8String(retval);
            //retval.replace(1)
        }
    });

    Interceptor.attach(sub_E56C, {
        onEnter: function (args) {
            console.log('2a')
            console.log(Memory.readCString(args[0]));
        },

        onLeave: function (retval) {
            console.log("2rretval:"+retval);
            //Memory.readUtf8String(retval);
            //retval.replace(1)
        }
    });
    Interceptor.attach(sub_E7F8, {
        onEnter: function (args) {
            console.log('3a')
            console.log(Memory.readCString(args[0]));
        },
        onLeave: function (retval) {
            console.log("3rretval:" + retval);
            return
            var data = Memory.readUtf8String(retval);
            var result = "bb4ME6An / z82AwX5r0FXgwJwzp3JaFgW7JtmKc4T9Q == ";

            var index = (round - 1) * 4;
            var result1 = result.substring(index, index + 4);
            if (data.substring(index, index + 4) == result1) {
                console.log("[+]Found:" + Memory.readUtf8String(retval));
            }
            //retval.replace(1)
        }
    });
}else{
    console.log("failed..")
}