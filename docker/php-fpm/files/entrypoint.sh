#!/usr/bin/env bash
set -e

/startup/wait-for-it.sh database:3306

$@