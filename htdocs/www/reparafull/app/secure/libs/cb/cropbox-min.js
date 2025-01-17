"use strict";
var cropbox = function (e) {

	var t = document.querySelector(e.imageBox),
	n = {
		state: {},
		ratio: 1,
		options: e,
		imageBox: t,
		thumbBox: t.querySelector(e.thumbBox),
		spinner: t.querySelector(e.spinner),
		image: new Image,
		getDataURL: function () {
			var e = this.thumbBox.clientWidth,
			n = this.thumbBox.clientHeight,
			a = document.createElement("canvas"),
			i = t.style.backgroundPosition.split(" "),
			o = t.style.backgroundSize.split(" "),
			r = parseInt(i[0]) - t.clientWidth / 2 + e / 2,
			s = parseInt(i[1]) - t.clientHeight / 2 + n / 2,
			c = parseInt(o[0]),
			u = parseInt(o[1]),
			d = parseInt(this.image.height),
			l = parseInt(this.image.width);
			a.width = e,
			a.height = n;
			var g = a.getContext("2d");
			g.drawImage(this.image, 0, 0, l, d, r, s, c, u);
			var m = a.toDataURL("image/png");
			return m
		},
		getBlob: function () {
			for (var e = this.getDataURL(), t = e.replace("data:image/png;base64,", ""), n = atob(t), a = [], i = 0; i < n.length; i++)
				a.push(n.charCodeAt(i));
			return new Blob([new Uint8Array(a)], {
				type: "image/png"
			})
		},
		zoomIn: function () {
			this.ratio *= 1.1,
			r();
			setCBsize();
		},
		zoomOut: function () {
			this.ratio *= .9,
			r();
			setCBsize();
		}
	},
	a = function (e, t, n) {
		e.attachEvent ? e.attachEvent("on" + t, n) : e.addEventListener && e.addEventListener(t, n)
	},
	i = function (e, t, n) {
		e.detachEvent ? e.detachEvent("on" + t, n) : e.removeEventListener && e.removeEventListener(t, render)
	},
	o = function (e) {
		window.event ? e.cancelBubble = !0 : e.stopImmediatePropagation()
	},
	r = function () {
		var e = parseInt(n.image.width) * n.ratio,
		a = parseInt(n.image.height) * n.ratio,
		i = (t.clientWidth - e) / 2,
		o = (t.clientHeight - a) / 2;
		t.setAttribute("style", "background-image: url(" + n.image.src + "); background-size: " + e + "px " + a + "px; background-position: " + i + "px " + o + "px; background-repeat: no-repeat")
	},
	s = function (e) {
		o(e),
		n.state.dragable = !0,
		n.state.mouseX = e.clientX,
		n.state.mouseY = e.clientY
	},
	c = function (e) {
		if (o(e), n.state.dragable) {
			var a = e.clientX - n.state.mouseX,
			i = e.clientY - n.state.mouseY,
			r = t.style.backgroundPosition.split(" "),
			s = a + parseInt(r[0]),
			c = i + parseInt(r[1]);
			t.style.backgroundPosition = s + "px " + c + "px",
			n.state.mouseX = e.clientX,
			n.state.mouseY = e.clientY
		}
	},
	u = function (e) {
		if(ispic == 1)
		{
			o(e),
			n.state.dragable = !1
		}
		
	},
	d = function (e) {
		var t = window.event || e,
		a = t.detail ? -120 * t.detail : t.wheelDelta;
		n.ratio *= a > -120 ? 1.1 : .9,
		r()
	};
	return n.spinner.style.display = "block",
	n.image.onload = function () {
		n.spinner.style.display = "none",
		r(),
		a(t, "mousedown", s),
		a(t, "mousemove", c),
		a(document.body, "mouseup", u);
		var e = /Firefox/i.test(navigator.userAgent) ? "DOMMouseScroll" : "mousewheel";
		a(t, e, d)
	},
	n.image.src = e.imgSrc,
	a(t, "DOMNodeRemoved", function () {
		i(document.body, "DOMNodeRemoved", u)
	}),
	n
};
