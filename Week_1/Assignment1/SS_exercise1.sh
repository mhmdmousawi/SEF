#!/bin/bash
ls -l --block-size=K /var/log/*.log | awk {'print $9", "$5'} | tr -d 'K' > /home/sef-mhmd/Desktop/log_dump.csv 

