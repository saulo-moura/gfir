ALTER TABLE `historicorealizacoescliente`
ADD COLUMN `idt`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST ,
ADD PRIMARY KEY (`idt`);

ALTER TABLE `historicorealizacoescliente_anosanteriores`
ADD COLUMN `idt`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST ,
ADD PRIMARY KEY (`idt`);

ALTER TABLE `historicorealizacoescliente`
DROP COLUMN `idt`,
DROP PRIMARY KEY;

ALTER TABLE `historicorealizacoescliente_anosanteriores`
DROP COLUMN `idt`,
DROP PRIMARY KEY;


SELECT MAX(idt) as idt FROM `historicorealizacoescliente`
GROUP BY rowguid
HAVING COUNT(codsebrae) > 1;

delete from historicorealizacoescliente
where idt in (
80, 31, 63, 9, 53, 28, 78, 81, 17, 82, 52, 68, 55, 60, 30, 61, 83, 79, 69, 29, 48, 32, 18, 77, 47
);

SELECT MAX(idt) as idt FROM `historicorealizacoescliente_anosanteriores`
GROUP BY rowguid
HAVING COUNT(codsebrae) > 1;

delete from historicorealizacoescliente_anosanteriores
where idt in (
221, 179, 162, 178, 220, 216, 145, 217, 161, 219, 223, 177, 163, 176, 184, 174, 175, 222, 218, 180
);