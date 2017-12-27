@echo off
cls
title syncing to xampp....
del C:\xampp\htdocs /r /f
xcopy src\* C:\xampp\htdocs /i /s /d /y