.PHONY: all dev ci ci-install install build watch clean

all: install build

dev: install watch

ci: install build i18n

ci-install: install

install:
	pnpm i

build:
	pnpm build

i18n:
	pnpm run js:i18n

watch:
	pnpm run watch

clean:
	rm -rf node_modules
	rm -rf build
