import { __ } from '@wordpress/i18n';
import {
  useBlockProps,
  InspectorControls,
  MediaUpload,
  MediaUploadCheck,
  InnerBlocks,
} from '@wordpress/block-editor';
import {
  PanelBody,
  Button as WPButton,
  TextControl,
  ToggleControl,
  CheckboxControl,
  PanelRow,
  BaseControl,      // ← импортировали
} from '@wordpress/components';
import { useSelect } from '@wordpress/data';

export default function Edit({ attributes, setAttributes }) {
  const {
    mode,
    selectAllInterviews,
    items,
    interviews,
  } = attributes;

  const blockProps = useBlockProps();

  // Загружаем все интервью
  const allInterviews = useSelect(
    (select) =>
      select('core').getEntityRecords('postType', 'interview', {
        per_page: -1,
      }),
    []
  ) || [];

  // Добавление, обновление, удаление слайдов
  const addSlide = () => {
    setAttributes({
      items: [
        ...items,
        { previewUrl: '', videoUrl: '', title: '', buttonText: '', buttonLink: '' },
      ],
    });
  };
  const updateSlide = (i, field, value) => {
    const newItems = items.slice();
    newItems[i][field] = value;
    setAttributes({ items: newItems });
  };
  const removeSlide = (i) => {
    const newItems = items.slice();
    newItems.splice(i, 1);
    setAttributes({ items: newItems });
  };

  return (
    <>
      <InspectorControls>
        <PanelBody title={__('Режим блока', 'biotropika')} initialOpen>
          <ToggleControl
            label={__('Custom‑режим', 'biotropika')}
            checked={mode === 'custom'}
            onChange={() =>
              setAttributes({ mode: mode === 'custom' ? 'interview' : 'custom' })
            }
          />
        </PanelBody>

        {mode === 'interview' && (
          <PanelBody title={__('Интервью', 'biotropika')} initialOpen>
            <ToggleControl
              label={__('Выбрать все интервью', 'biotropika')}
              checked={selectAllInterviews}
              onChange={(val) => setAttributes({ selectAllInterviews: val })}
            />
            {!selectAllInterviews && (
              <>
                <PanelRow>{__('Выберите интервью:', 'biotropika')}</PanelRow>
                {allInterviews.length === 0 && (
                  <PanelRow>{__('Нет доступных интервью.', 'biotropika')}</PanelRow>
                )}
                {allInterviews.map((post) => (
                  <CheckboxControl
                    key={post.id}
                    label={post.title.rendered}
                    checked={interviews.includes(post.id)}
                    onChange={(checked) =>
                      setAttributes({
                        interviews: checked
                          ? [...interviews, post.id]
                          : interviews.filter((id) => id !== post.id),
                      })
                    }
                  />
                ))}
              </>
            )}
          </PanelBody>
        )}
      </InspectorControls>

      <div {...blockProps}>
        {mode === 'custom' &&
          items.map((item, index) => (
            <PanelBody
              title={`${__('Слайд', 'biotropika')} ${index + 1}`}
              initialOpen={false}
              key={index}
            >
              <PanelRow>
                <MediaUploadCheck>
                  <MediaUpload
                    onSelect={(media) => updateSlide(index, 'previewUrl', media.url)}
                    allowedTypes={['image']}
                    render={({ open }) => (
                      <WPButton onClick={open} isSecondary>
                        {item.previewUrl
                          ? __('Изменить превью', 'biotropika')
                          : __('Выбрать превью', 'biotropika')}
                      </WPButton>
                    )}
                  />
                </MediaUploadCheck>
              </PanelRow>

              {item.previewUrl && (
                <img
                  src={item.previewUrl}
                  alt=""
                  style={{ display: 'block', maxWidth: '100%', margin: '10px 0' }}
                />
              )}

              <TextControl
                label={__('URL видео', 'biotropika')}
                value={item.videoUrl}
                onChange={(val) => updateSlide(index, 'videoUrl', val)}
              />

              <TextControl
                label={__('Заголовок', 'biotropika')}
                value={item.title}
                onChange={(val) => updateSlide(index, 'title', val)}
              />

              {/*
                Оборачиваем InnerBlocks в BaseControl,
                чтобы появилась подпись и мы могли через CSS задать рамку
              */}
              <BaseControl label={__('Текст слайда', 'biotropika')}>
                <div className="slide__content-wrapper">
                  <InnerBlocks
                    allowedBlocks={['core/paragraph', 'core/heading']}
                    templateLock={false}
                  />
                </div>
              </BaseControl>

              <TextControl
                label={__('Текст кнопки', 'biotropika')}
                value={item.buttonText}
                onChange={(val) => updateSlide(index, 'buttonText', val)}
              />
              <TextControl
                label={__('Ссылка кнопки', 'biotropika')}
                value={item.buttonLink}
                onChange={(val) => updateSlide(index, 'buttonLink', val)}
              />

              <PanelRow>
                <WPButton isLink isDestructive onClick={() => removeSlide(index)}>
                  {__('Удалить слайд', 'biotropika')}
                </WPButton>
              </PanelRow>
            </PanelBody>
          ))}

        {mode === 'custom' && (
          <PanelRow>
            <WPButton isPrimary onClick={addSlide}>
              {__('Добавить слайд', 'biotropika')}
            </WPButton>
          </PanelRow>
        )}

        {mode === 'interview' && (
          <p>
            {selectAllInterviews
              ? __('Показываем все интервью', 'biotropika')
              : __('Показываем выбранные интервью', 'biotropika')}
          </p>
        )}
      </div>
    </>
  );
}
