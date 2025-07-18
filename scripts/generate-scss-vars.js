const fs = require('fs');
const path = require('path');

const theme = require(path.join(__dirname, '..', 'theme.json'));

const palette = theme.settings.color.palette;

let scss = '// Автоматически сгенерировано из theme.json\n';
scss += ':root {\n';
palette.forEach(c => {
  scss += `  --color-${c.slug}: ${c.color};\n`;
});
scss += '}\n\n';
palette.forEach(c => {
  scss += `$color-${c.slug}: ${c.color};\n`;
});

fs.writeFileSync(path.join(__dirname, '..', 'src', 'scss', '_variables.scss'), scss);

console.log('SCSS переменные успешно сгенерированы!');
