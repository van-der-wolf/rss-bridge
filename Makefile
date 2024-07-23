build:
	docker buildx create --use
	docker buildx build  --platform linux/amd64,linux/arm/v7,linux/arm64/v8 -t registry.prokopenko.me/rss-bridge:latest . --push

push:
	docker push registry.prokopenko.me/rss-bridge:latest

run:
	docker run --name bridge -d -p 8086:80 -e PHP_IDE_CONFIG=serverName=bridge --add-host="host.docker.internal:host-gateway" -v .:/app registry.prokopenko.me/rss-bridge:latest
