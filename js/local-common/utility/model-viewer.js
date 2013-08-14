var g_chr_races = {
    1: "Человек",
    2: "Орк",
    3: "Дворф",
    4: "Ночной эльф",
    5: "Нежить",
    6: "Таурен",
    7: "Гном",
    8: "Тролль",
    9: "Гоблин",
    10: "Эльф крови",
    11: "Дреней",
    22: "Ворген"
};

var LANG = {
    male: "Мужчина",
    female: "Женщина",
    animation: "Анимация",
    tooltip_loading: "Загрузка...",
    dialog_mouseovertoload: "Наведите мышкой для загрузки...",
    close: "Закрыть",
    help: "Помощь",
    model: "Модель"
};

var g_staticUrl = "http://static.wowhead.com";

strcmp = function(d,c) {
    if(d == c) { return 0 }
    if(d == null) { return -1 }
    if(c == null) { return 1 }
    var f = parseFloat(d);
    var e = parseFloat(c);
    if(!isNaN(f) && !isNaN(e) && f!=e) { return f < e ? -1 : 1 }
    if(typeof d == "string" && typeof c == "string") { return d.localeCompare(c) }
    return d < c ? -1 : 1
};

in_array=function(c,g,h,e){if(c==null){return -1}if(h){return in_arrayf(c,g,h,e)}for(var d=e||0,b=c.length;d<b;++d){if(c[d]==g){return d}}return -1};
in_arrayf=function(c,g,h,e){for(var d=e||0,b=c.length;d<b;++d){if(h(c[d])==g){return d}}return -1};

var ModelViewer = new function () {
        this.validSlots = [1, 3, 4, 5, 6, 7, 8, 9, 10, 13, 14, 15, 16, 17, 19, 20, 21, 22, 23, 25, 26];
        this.slotMap = {
            1: 1,
            3: 3,
            4: 4,
            5: 5,
            6: 6,
            7: 7,
            8: 8,
            9: 9,
            10: 10,
            13: 21,
            14: 22,
            15: 22,
            16: 16,
            17: 21,
            19: 19,
            20: 5,
            21: 21,
            22: 22,
            23: 22,
            25: 21,
            26: 21
        };
        var e, F, I = [],
            i, C, r, E, h, G, p, u, v, f, q, A, z, o, c = false,
            races = [{
                id: 3,
                name: g_chr_races[3],
                model: "dwarf"
            }, {
                id: 7,
                name: g_chr_races[7],
                model: "gnome"
            }, {
                id: 1,
                name: g_chr_races[1],
                model: "human"
            }, {
                id: 4,
                name: g_chr_races[4],
                model: "nightelf"
            }, {
                id: 2,
                name: g_chr_races[2],
                model: "orc"
            }, {
                id: 6,
                name: g_chr_races[6],
                model: "tauren"
            }, {
                id: 8,
                name: g_chr_races[8],
                model: "troll"
            }, {
                id: 5,
                name: g_chr_races[5],
                model: "scourge"
            }],
            genders = [{
                id: 0,
                name: LANG.male,
                model: "male"
            }, {
                id: 1,
                name: LANG.female,
                model: "female"
            }];

        function D() {
            C.hide();
            r.hide();
            E.hide()
        }
        function a() {
            var J, K;
            if (u.is(":visible")) {
                J = (u[0].selectedIndex >= 0 ? u.val() : "")
            } else {
                J = (v[0].selectedIndex >= 0 ? v.val() : "")
            }
            K = (f[0].selectedIndex >= 0 ? f.val() : 0);
            return {
                r: J,
                s: K
            }
        }
        function d(J, K) {
            return (!isNaN(J) && J > 0 && in_array(races, J, function (L) {
                return L.id
            }) != -1 && !isNaN(K) && K >= 0 && K <= 1)
        }
        function B() {
            var K = 725;

            G.css("width", K + "px");
            if (A == 2 && !g()) {
                A = 0
            }
            if (A == 2) {
                var O = '<object id="3dviewer-plugin" type="application/x-zam-wowmodel" width="' + K + '" height="500"><param name="model" value="' + e + '" /><param name="modelType" value="' + F + '" /><param name="contentPath" value="' + g_staticUrl + '/modelviewer/" />';
                if (F == 16 && I.length) {
                    O += '<param name="equipList" value="' + I.join(",") + '" />'
                }
                O += '<param name="bgColor" value="#341a0f" /></object>';
                E.html(O);
                E.show();
                p.hide()
            } else {
                if (A == 1) {
                    var O = '<applet id="3dviewer-java" code="org.jdesktop.applet.util.JNLPAppletLauncher" width="' + K + '" height="500" archive="' + g_staticUrl + "/modelviewer/applet-launcher.jar,http://download.java.net/media/jogl/builds/archive/jsr-231-webstart-current/jogl.jar,http://download.java.net/media/gluegen/webstart/gluegen-rt.jar,http://download.java.net/media/java3d/webstart/release/vecmath/latest/vecmath.jar," + g_staticUrl + '/modelviewer/ModelView1000.jar"><param name="jnlp_href" value="' + g_staticUrl + '/modelviewer/ModelView1000.jnlp"><param name="codebase_lookup" value="false"><param name="cache_option" value="no"><param name="subapplet.classname" value="modelview.ModelViewerApplet"><param name="subapplet.displayname" value="Model Viewer Applet"><param name="progressbar" value="true"><param name="jnlpNumExtensions" value="1"><param name="jnlpExtension1" value="http://download.java.net/media/jogl/builds/archive/jsr-231-webstart-current/jogl.jnlp"><param name="contentPath" value="' + g_staticUrl + '/modelviewer/"><param name="model" value="' + e + '"><param name="modelType" value="' + F + '">';
                    if (F == 16 && I.length) {
                        O += '<param name="equipList" value="' + I.join(",") + '">'
                    }
                    O += '<param name="bgColor" value="#341a0f"></applet>';
                    r.html(O);
                    r.show();
                    p.show()
                } else {
                    var L = {
                        model: e,
                        modelType: F,
                        contentPath: g_staticUrl + "/modelviewer/",
                        blur: "0"
                    };
                    var N = {
                        quality: "high",
                        allowscriptaccess: "always",
                        allowfullscreen: true,
                        menu: false,
                        bgcolor: "#341a0f"
                    };
                    var M = {};
                    if (F == 16 && I.length) {
                        L.equipList = I.join(",")
                    }
                    swfobject.embedSWF(g_staticUrl + "/modelviewer/ModelView.swf", "dsjkgbdsg2346", K, "500", "10.0.0", "http://static.wowhead.com/modelviewer/expressInstall.swf", L, N, M);
                    C.show();
                    p.hide()
                }
            }
            var R = a(),
                P = R.r,
                Q = R.s;
            if (!i.noPound) {
                var J = "#modelviewer";
                var R = $("#dsgndslgn464d");
                if (R.length == 0) {
                    switch (i.type) {
                    case 1:
                        J += ":1:" + i.displayId + ":" + (i.humanoid | 0);
                        break;
                    case 2:
                        J += ":2:" + i.displayId;
                        break;
                    case 3:
                        J += ":3:" + i.displayId + ":" + (i.slot | 0);
                        break;
                    case 4:
                        J += ":4:" + I.join(";");
                        break
                    }
                }
                if (P && Q) {
                    J += ":" + P + "+" + Q
                } else {
                    J += ":"
                }
                if (i.extraPound != null) {
                    J += ":" + i.extraPound
                }
                c = false;
                //location.replace($WH.rtrim(J, ":"))
            }
        }
        function b() {
            var N = a(),
                K = N.r,
                L = N.s;
            if (!K) {
                if (!f.is(":visible")) {
                    return
                }
                f.hide();
                e = I[1];
                switch (i.slot) {
                case 1:
                    F = 2;
                    break;
                case 3:
                    F = 4;
                    break;
                default:
                    F = 1
                }
            } else {
                if (!f.is(":visible")) {
                    f.show()
                }
                var N = function (O) {
                        return O.id
                    };
                var M = in_array(races, K, N);
                var J = in_array(genders, L, N);
                if (M != -1 && J != -1) {
                    e = races[M].model + genders[J].model;
                    F = 16
                }
                //g_setWowheadCookie("temp_default_3dmodel", K + "," + L)
            }
            D();
            B()
        }
        function n() {
            var K = $("#3dviewer-java");
            if (K.length == 0) {
                return
            }
            K = K[0];
            var J = $("select", p);
            if (J.val() && K.isLoaded && K.isLoaded()) {
                K.setAnimation(J.val())
            }
        }
        function m() {
            if (c) {
                return
            }
            var O = $("#3dviewer-java");
            if (O.length == 0) {
                return
            }
            O = O[0];
            var L = $("select", p);
            L.empty();
            if (!O.isLoaded || !O.isLoaded()) {
                L.append($("<option/>", {
                    text: LANG.tooltip_loading,
                    val: 0
                }));
                return
            }
            var J = {};
            var N = O.getNumAnimations();
            for (var M = 0; M < N; ++M) {
                var K = O.getAnimation(M);
                if (K) {
                    J[K] = 1
                }
            }
            var P = [];
            for (var K in J) {
                P.push(K)
            }
            P.sort();
            for (var M = 0; M < P.length; ++M) {
                L.append($("<option/>", {
                    text: P[M],
                    val: P[M]
                }))
            }
            c = true
        }
        function w(P, K) {
            var R = -1,
                T = -1,
                L, O;
            if (K.race != null && K.sex != null) {
                R = K.race;
                T = K.sex;
                h.hide();
                P = 0
            } else {
                h.show()
            }
            if (R == -1 && T == -1) {
                if (location.hash) {
                    var Q = location.hash.match(/modelviewer:.*?([0-9]+)\+([0-9]+)/);
                    if (Q != null) {
                        if (d(Q[1], Q[2])) {
                            R = Q[1];
                            T = Q[2];
                            f.show()
                        }
                    }
                }
            }
            if (P) {
                L = u;
                O = 1;
                u.show();
                u[0].selectedIndex = -1;
                v.hide();
                if (T == -1) {
                    f.hide()
                }
            } else {
                if (R == -1 && T == -1) {
                    var W = 1,
                        N = 0;
                    /*if (g_user && g_user.cookies.default_3dmodel) {
                        var J = g_user.cookies.default_3dmodel.split(",");
                        if (J.length == 2) {
                            W = J[0];
                            N = J[1] - 1
                        }
                    } else {
                        var S = g_getWowheadCookie("temp_default_3dmodel");
                        if (S) {
                            var J = S.split(",");
                            if (J.length == 2) {
                                W = J[0];
                                N = J[1]
                            }
                        }
                    }*/
                    if (d(W, N)) {
                        R = W;
                        T = N
                    } else {
                        R = 1;
                        T = 0
                    }
                }
                L = v;
                O = 0;
                u.hide();
                v.show();
                f.show()
            }
            if (T != -1) {
                f[0].selectedIndex = T
            }
            if (R != -1 && T != -1) {
                var V = function (X) {
                        return X.id
                    };
                var U = in_array(races, R, V);
                var M = in_array(genders, T, V);
                if (U != -1 && M != -1) {
                    e = races[U].model + genders[M].model;
                    F = 16;
                    U += O;
                    L[0].selectedIndex = U;
                    f[0].selectedIndex = M
                }
            }
        }
        function g() {
            var K = navigator.mimeTypes["application/x-zam-wowmodel"];
            if (K) {
                var J = K.enabledPlugin;
                if (J) {
                    return true
                }
            }
            return false
        }
        function l() {
            if (!i.noPound) {
                if (!i.fromTag && q && q.indexOf("modelviewer") == -1) {
                    location.replace(q)
                } else {
                    location.replace("#.")
                }
            }
            if (i.onHide) {
                i.onHide()
            }
        }
        this.renderJava = function()
        {
            ModelViewer.k(1);
        };
        
        this.renderFlash = function()
        {
            ModelViewer.k(0);
        };
        
        this.k = function(J) {
        
            if (J == A) {
                return
            }
            //g_setSelectedLink(this, "modelviewer-mode");
            D();
            if (A == null) {
                A = J;
                setTimeout(B, 50)
            } else {
                A = J;
                //$WH.sc("modelviewer_mode", 7, J, "/", ".wowhead.com");
                B()
            }
        };
        
        this.render = function(frame, data) {
            var linkFlash, linkJava;
            z = data;

            frame.addClass("modelviewer");
            var N = $("<div/>", {"class": "modelviewer-screen"});
            C = $("<div/>", {css: {display: "none"}});
            r = $("<div/>", {css: {display: "none"}});
            E = $("<div/>", {css: {display: "none"}});
            var W = $("<div/>", {id: "dsjkgbdsg2346"});
                C.append(W);
                N.append(C);
                N.append(r);
                N.append(E);
                var R = $("<div/>", {
                    css: {
                        "background-color": "#341a0f",
                        margin: "0"
                    }
                });
                R.append(N);
            frame.append(R);
                G = N;
            var right_frame = $("<div/>", {css: {"float": "right"}});
            var Z = $("<div/>", {css: {"float": "left"}});
                p = $("<div/>", {
                    "class": "modelviewer-animation"
                });
                var P = $("<var/>", {
                    text: LANG.animation
                });
                p.append(P);
                var aa = $("<select/>", {
                    change: n,
                    mouseenter: m
                });
                aa.append($("<option/>", {
                    text: LANG.dialog_mouseovertoload
                }));
                p.append(aa);
            right_frame.append(p);
            frame.append(right_frame);
            
                h = $("<div/>", {
                    "class": "modelviewer-model"
                });
                var W = function (af, ae) {
                        return strcmp(af.name, ae.name)
                    };
            races.sort(W);
            u = $("<select/>", {change: b});
            v = $("<select/>", {change: b});
            f = $("<select/>", {change: b});
            u.append($("<option/>"));
            for (var U = 0, V = races.length; U < V; ++U) {
                var S = $("<option/>", {
                    val: races[U].id,
                    text: races[U].name
                });
                u.append(S)
            }
            for (var U = 0, V = races.length; U < V; ++U) {
                var S = $("<option/>", {
                    val: races[U].id,
                    text: races[U].name
                });
                v.append(S)
            }
            for (var U = 0, V = genders.length; U < V; ++U) {
                var S = $("<option/>", {
                    val: genders[U].id,
                    text: genders[U].name
                });
                f.append(S)
            }
            f.hide();
            var P = $("<var/>", {text: LANG.model});
            h.append(P);
            h.append(u);
            h.append(v);
            h.append(f);
            Z.append(h);
            frame.append(Z);
            
            var X = $("<div/>", {
                "class": "modelviewer-quality"
            }),
            links = $("<span/>"),
            linkFlash = $("<a/>", {
                id: "linkFlash",
                href: "javascript:;",
                text: "Flash"
            }),
            linkJava = $("<a/>", {
                id: "linkJava",
                href: "javascript:;",
                text: "Java"
            });
            links.append(linkFlash);
            links.append(" " + String.fromCharCode(160));
            links.append(linkJava);
            if (g()) {
                var linkPlugin = $("<a/>", {
                    href: "javascript:;",
                    text: "Plugin"
                });
                linkPlugin.click(k.bind(ab[0], 2));
                links.append(" " + String.fromCharCode(160));
                links.append(ab)
            }
            var P = $("<var/>", {text: LANG.quality});
            X.append(P);
            X.append(links);
            Z.append(X);
            
            X = $("<div/>", {"class": "clear"});
            frame.append(X);
                X = $("<div/>", {
                    id: "modelviewer-msg",
                    "class": "sub",
                    css: {
                        display: "none",
                        "margin-top": "-6px",
                        color: "#ccc",
                        "font-size": "11px"
                    }
                });
            frame.append(X);

            switch (data.type) {
            case 1:
                h.hide();
                if (data.humanoid) {
                    F = 32
                } else {
                    F = 8
                }
                e = data.displayId;
                break;
            case 2:
                h.hide();
                F = 64;
                e = data.displayId;
                break;
            case 3:
            case 4:
                if (data.type == 3) {
                    I = [data.slot, data.displayId]
                } else {
                    I = data.equipList
                }
                if (I.length > 2 || in_array([4, 5, 6, 7, 8, 9, 10, 16, 19, 20], I[0]) != -1) {
                    w(0, data)
                } else {
                    switch (I[0]) {
                    case 1:
                        F = 2;
                        break;
                    case 3:
                        F = 4;
                        break;
                    default:
                        F = 1
                    }
                    e = I[1];
                    w(1, data)
                }
                break
            }
            var Y = $("#modelviewer-ad");
            if (frame) {
                /*if ($WH.gc("modelviewer_mode") == "2" && g()) {
                    linkPlugin.click()
                } else {
                    if ($WH.gc("modelviewer_mode") == "0") {
                        linkFlash.click()
                    } else {
                        linkJava.click()
                    }
                }*/
                //linkJava.click()
            } else {
                Y.empty();
                D();
                setTimeout(B, 1)
            }
            var K = $("#modelviewer-msg");
            if (data.message && K.length > 0) {
                K.html(data.message);
                K.show()
            } else {
                K.hide()
            }
            var M = "";
            if (data.fromTag) {
                M += "Custom ";
                switch (data.type) {
                case 1:
                    M += "NPC " + data.displayId + (data.humanoid ? " humanoid" : "");
                    break;
                case 2:
                    M += "Object " + data.displayId;
                    break;
                case 3:
                    M += "Item " + data.displayId + " Slot " + (data.slot | 0);
                    break;
                case 4:
                    M += "Item set " + I.join(".");
                    break
                }
            } else {
                switch (data.type) {
                case 1:
                    M += "NPC " + (data.typeId ? data.typeId : " DisplayID " + data.displayId);
                    break;
                case 2:
                    M += "Object " + data.typeId;
                    break;
                case 3:
                    M += "Item " + data.typeId;
                    break;
                case 4:
                    M += "Item set " + I.join(".");
                    break
                }
            }
            //g_trackEvent("Model Viewer", "Show", g_urlize(M));
            q = location.hash
        };
        this.checkPound = function () {
            if (location.hash && location.hash.indexOf("#modelviewer") == 0) {
                var N = location.hash.split(":");
                if (N.length >= 3) {
                    N.shift();
                    var L = parseInt(N.shift());
                    var K = {
                        type: L,
                        displayAd: 1
                    };
                    switch (L) {
                    case 1:
                        K.displayId = parseInt(N.shift());
                        var J = parseInt(N.shift());
                        if (J == 1) {
                            K.humanoid = 1
                        }
                        break;
                    case 2:
                        K.displayId = parseInt(N.shift());
                        break;
                    case 3:
                        K.displayId = parseInt(N.shift());
                        K.slot = parseInt(N.shift());
                        break;
                    case 4:
                        var M = N.shift();
                        K.equipList = M.split(";");
                        break
                    }
                    if (K.displayId || K.equipList) {
                        ModelViewer.show(K)
                    }
                    if (o != null) {
                        if (N.length > 0 && N[N.length - 1]) {
                            o(N[N.length - 1])
                        }
                    }
                } else {
                    if (o != null && N.length == 2 && N[1]) {
                        o(N[1])
                    } else {
                        var O = $("#dsgndslgn464d");
                        if (O.length > 0) {
                            O.click()
                        }
                    }
                }
            }
        };
        this.addExtraPound = function (J) {
            o = J
        };
        this.show = function (data) {
            i = data;
            Lightbox.loadModel(data);
            $("#linkFlash").bind('click', ModelViewer.renderFlash);
            $("#linkJava").bind('click', ModelViewer.renderJava);
            $("#linkFlash").click();
        };
        $(document).ready(this.checkPound)
    };