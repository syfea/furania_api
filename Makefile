path = docker

clean:
	docker system prune -a -f

rebuild: clean build

run:
	cd $(path) && docker run --rm -p 81:80 symfony

rerun: rebuild run

compose:
	docker-compose up --build -d

start:
	docker-compose up -d

stop:
	@docker-compose down

restart: stop start

build:
	docker-compose build
