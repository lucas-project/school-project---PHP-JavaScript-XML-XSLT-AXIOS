<?xml version="1.0"?><!-- DWXMLSource="../../admin/goods.xml" -->
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html"/>
    <xsl:template match="/">
        <HTML>
            <HEAD>
                <TITLE> Goods</TITLE>
            </HEAD>
            <BODY>
                Item quantity greater than 0(quantity on hold or sold not included) : <BR/>

<!--                <xsl:for-each select="//Unit[points &gt; 12.5]">-->
<!--                    <span>-->
<!--                        <xsl:attribute name="style">-->
<!--                            <xsl:text>font-weight:bold;</xsl:text>-->
<!--                        </xsl:attribute>-->
<!--                        <xsl:value-of select="Faculty"/>-->
<!--                    </span><br/>-->
<!--                    <span>-->
<!--                        <xsl:attribute name="style">-->
<!--                            <xsl:text>color:red;</xsl:text>-->
<!--                        </xsl:attribute>-->
<!--                        <xsl:value-of select="group"/>-->
<!--                    </span><br/>-->
<!--                    <span><xsl:value-of select="points"/></span><br/>-->
<!--                    <p></p>-->
<!--                </xsl:for-each>-->

                <xsl:for-each select="//item[quantity &gt; 0]">
                    <span>
                        <xsl:attribute name="style">
                            <xsl:text>font-weight:bold;</xsl:text>
                        </xsl:attribute>
                        <xsl:value-of select="name"/>
                    </span><br/>
                    <span>
                        <xsl:attribute name="style">
                            <xsl:text>color:red;</xsl:text>
                        </xsl:attribute>
                        <xsl:value-of select="price"/>
                    </span><br/>
                    <span><xsl:value-of select="quantity"/></span><br/>
                    <p></p>
                </xsl:for-each>

            </BODY>
        </HTML>
    </xsl:template>
</xsl:stylesheet>