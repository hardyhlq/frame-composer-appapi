@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../cheler/frame/projectLw
bash "%BIN_TARGET%" %*
