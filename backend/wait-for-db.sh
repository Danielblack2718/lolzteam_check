#!/bin/bash

set -e

host="$1"
shift
port="$1"
shift
user="$1"
shift
password="$1"
shift
cmd="$@"

until mysql -h"$host" -P"$port" -u"$user" -p"$password" -e 'select 1'; do
  >&2 echo "MySQL is unavailable - sleeping"
  sleep 1
done

>&2 echo "MySQL is up - executing command"
exec $cmd
