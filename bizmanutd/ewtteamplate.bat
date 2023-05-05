@echo off
:: v1.0
:: ======================== Setup ============================
set host=localhost
set mysqluser=root
set mysqlpass=root
set master=db_404_monre_web
set replicate=db_405_monre_two db_406_monre_three

::=========================================================
:: ชื่อ table ที่จะ export :: ห้ามแก้ไข
set tables=block block_function block_member block_text block_visit design_block design_list design_module design_series design_series_function menu_default menu_list menu_log menu_properties menu_seting menu_setting menu_sitemap_list temp_index temp_magic temp_main_group template_module themes
::=========================================================
:: ตำแหน่งปลายทางที่จะเก็บ
set pathbak=
:: ตำแหน่งไฟล์ mysqldump บนเครื่องที่สั่งทำงาน ****สำคัญ****
::set mysqldumppath=C:\wamp\bin\mysql\mysql5.1.32\bin\
set mysqldumppath=
:: ======================== Process ==========================
set mysqluser=-u%mysqluser%
if "%mysqlpass%" NEQ "" ( set mysqlpass=-p%mysqlpass%)
if "%master%" == "" ( echo.Please select database. )
::set master=--all-database&set namebak=all-database
if "%pathbak%" == "" ( set pathbak=)
set bkupfilename=%master%_template.sql
echo.Export from %master%
"%mysqldumppath%mysqldump"  --lock-tables=false -h%host% %mysqluser% %mysqlpass% %master% %tables% > "%pathbak%%bkupfilename%"  
call:import %replicate%
GOTO:EOF
::echo Backup Complete!
:import
FOR %%A IN (%*) DO (
echo.
echo Import to %%A
"%mysqldumppath%mysql"  -h%host% %mysqluser% %mysqlpass% %%A < "%pathbak%%bkupfilename%" 
)
del  "%pathbak%%bkupfilename%" 
echo.&echo Complete.&echo.
pause
GOTO:EOF
