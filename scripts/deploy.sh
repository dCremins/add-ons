#!/bin/bash

set -o errexit

rm -rf public
mkdir public

# config
git config --global user.email "devincrem@gmail.com"
git config --global user.name "Travis CI"

# build (CHANGE THIS)
make

# deploy
cd public
git init
git add .
git commit -m "Deploy to Github Pages"
git push --force --quiet "https://${DEPLOY_KEY}@$github.com/dCremins/add-ons.git" development:master > /dev/null 2>&1
