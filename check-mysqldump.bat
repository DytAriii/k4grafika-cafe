@echo off
echo ========================================
echo Cek Path mysqldump untuk Backup
echo ========================================
echo.

echo Mencari mysqldump di Laragon (Drive C:)...
if exist "C:\laragon\bin\mysql\" (
    echo Ditemukan di C:\laragon
    for /d %%i in (C:\laragon\bin\mysql\*) do (
        if exist "%%i\bin\mysqldump.exe" (
            echo.
            echo Path untuk .env (gunakan double backslash):
            echo DB_DUMP_PATH="%%i\bin"
            echo.
            echo Atau dengan double backslash:
            set "path_temp=%%i\bin"
            setlocal enabledelayedexpansion
            echo DB_DUMP_PATH="!path_temp:\=\\!"
            endlocal
        )
    )
) else (
    echo Laragon tidak ditemukan di C:\laragon
)

echo.
echo Mencari mysqldump di Laragon (Drive E:)...
if exist "E:\laragon\bin\mysql\" (
    echo Ditemukan di E:\laragon
    for /d %%i in (E:\laragon\bin\mysql\*) do (
        if exist "%%i\bin\mysqldump.exe" (
            echo.
            echo Path untuk .env (gunakan double backslash):
            set "path_temp=%%i\bin"
            setlocal enabledelayedexpansion
            echo DB_DUMP_PATH="!path_temp:\=\\!"
            endlocal
        )
    )
) else (
    echo Laragon tidak ditemukan di E:\laragon
)

echo.
echo Mencari mysqldump di XAMPP...
if exist "C:\xampp\mysql\bin\mysqldump.exe" (
    echo.
    echo Path untuk .env:
    echo DB_DUMP_PATH="C:\\xampp\\mysql\\bin"
) else (
    echo XAMPP tidak ditemukan di C:\xampp
)

echo.
echo ========================================
echo PENTING:
echo 1. Copy path di atas ke file .env
echo 2. Gunakan DOUBLE BACKSLASH (\\)
echo 3. Path ke FOLDER bin, bukan file .exe
echo 4. Jalankan: php artisan config:clear
echo 5. Test: php artisan backup:run --only-db
echo ========================================
echo.
pause
