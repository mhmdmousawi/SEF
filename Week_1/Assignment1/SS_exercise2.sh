#!/bin/bash

#1.Retrieve the current Virtual Memory utilization value
cat /proc/swaps 

#2.Retrieve the current Used Disk Space value (for all mouted drives)
df | awk {'print $1" "$3'}
//df | tr $5 -d "%" | awk '$5 = 2 {print 2;next};1' 