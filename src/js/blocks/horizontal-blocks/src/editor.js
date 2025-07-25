import { __ } from '@wordpress/i18n';
import {
  useBlockProps,
  InspectorControls,
} from '@wordpress/block-editor';
import {
  PanelBody,
  TextControl,
  Button as WPButton,
  PanelRow,
} from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
  const { items } = attributes;
  const blockProps = useBlockProps();

  // Добавить новый блок (макс. 3)
  const addItem = () => {
    if (items.length >= 3) return;
    setAttributes({
      items: [
        ...items,
        { title: '', text: '', buttonText: '', buttonLink: '' },
      ],
    });
  };

  // Обновить значение в конкретном поле
  const updateItem = (index, field, value) => {
    const newItems = items.slice();
    newItems[index][field] = value;
    setAttributes({ items: newItems });
  };

  // Удалить блок
  const removeItem = (index) => {
    const newItems = items.slice();
    newItems.splice(index, 1);
    setAttributes({ items: newItems });
  };

  return (
    <>
      <InspectorControls>
        <PanelBody
          title={__('Горизонтальные блоки', 'biotropika')}
          initialOpen
        >
          {items.map((item, idx) => (
            <PanelBody
              key={idx}
              title={`${__('Блок', 'biotropika')} ${idx + 1}`}
              initialOpen={false}
            >
              <TextControl
                label={__('Заголовок', 'biotropika')}
                value={item.title}
                onChange={(val) => updateItem(idx, 'title', val)}
              />

              <TextControl
                label={__('Текст блока', 'biotropika')}
                value={item.text}
                onChange={(val) => updateItem(idx, 'text', val)}
              />

              <TextControl
                label={__('Текст кнопки', 'biotropika')}
                value={item.buttonText}
                onChange={(val) => updateItem(idx, 'buttonText', val)}
              />

              <TextControl
                label={__('Ссылка кнопки', 'biotropika')}
                value={item.buttonLink}
                onChange={(val) => updateItem(idx, 'buttonLink', val)}
              />

              <PanelRow>
                <WPButton
                  isLink
                  isDestructive
                  onClick={() => removeItem(idx)}
                >
                  {__('Удалить блок', 'biotropika')}
                </WPButton>
              </PanelRow>
            </PanelBody>
          ))}

          <PanelRow>
            <WPButton
              isPrimary
              onClick={addItem}
              disabled={items.length >= 3}
            >
              {__('Добавить блок', 'biotropika')}
            </WPButton>
          </PanelRow>
        </PanelBody>
      </InspectorControls>

      <div {...blockProps}>
        {items.length > 0 ? (
          items.map((item, idx) => (
            <div className="horizontal-blocks__preview" key={idx}>
              <strong>
                {item.title || __('(заголовок пустой)', 'biotropika')}
              </strong>
              {item.text && (
                <p className="horizontal-blocks__text-preview">
                  {item.text}
                </p>
              )}
              <em>
                {item.buttonText
                  ? `${item.buttonText} → ${item.buttonLink}`
                  : __('(кнопка не задана)', 'biotropika')}
              </em>
            </div>
          ))
        ) : (
          <p>{__('Добавьте блоки в боковой панели', 'biotropika')}</p>
        )}
      </div>
    </>
  );
}
