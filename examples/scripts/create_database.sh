#!/usr/bin/env bash

set -e

test -f "$(dirname "$0")/../rulerz.db" && rm "$(dirname "$0")/../rulerz.db"

sqlite3 "$(dirname "$0")/../rulerz.db" < "$(dirname "$0")/../database.sql"