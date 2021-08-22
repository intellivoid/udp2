clean:
	rm -rf build

update:
	ppm --generate-package="src/udp2"

build:
	mkdir build
	ppm --no-intro --compile="src/udp2" --directory="build"

install:
	ppm --no-prompt --fix-conflict --install="build/net.intellivoid.udp2.ppm"