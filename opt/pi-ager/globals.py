#!/usr/bin/python3
# -*- coding: iso-8859-1 -*-
# globals.py
"""
pi-ager global values
"""
import threading

def init():
    global lock
    lock = threading.Lock()
    global hands_off_light_switch
    hands_off_light_switch = False
    global switch_control_uv_light
    switch_control_uv_light = 0
    global switch_control_light
    switch_control_light = 0   
    