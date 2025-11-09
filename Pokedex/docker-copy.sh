#!/bin/bash
IMAGE_NAME=$1
IMAGE_PATH=$2
LOCAL_PATH=$3

ID=$(docker create $IMAGE_NAME)
docker cp $ID:$IMAGE_PATH $LOCAL_PATH
docker rm $ID